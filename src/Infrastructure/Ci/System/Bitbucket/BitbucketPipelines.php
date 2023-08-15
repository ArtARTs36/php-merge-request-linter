<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\MergeRequestNotFoundException;
use ArtARTs36\MergeRequestLinter\Domain\CI\PostCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\CreateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\LabelsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\BitbucketPipelinesSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\RequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\NotFoundException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Markdown;
use ArtARTs36\Str\Str;
use Psr\Log\LoggerInterface;

class BitbucketPipelines implements CiSystem
{
    public const NAME = 'bitbucket_pipelines';

    public function __construct(
        private readonly Client                     $client,
        private readonly BitbucketEnvironment       $environment,
        private readonly MarkdownCleaner            $markdownCleaner,
        private readonly BitbucketPipelinesSettings $settings,
        private readonly LabelsResolver             $labelsResolver,
        private readonly LoggerInterface            $logger,
    ) {
        //
    }

    /**
     * @codeCoverageIgnore
     */
    public function getName(): string
    {
        return self::NAME;
    }

    public function isCurrentlyWorking(): bool
    {
        return $this->environment->isWorking();
    }

    public function isCurrentlyMergeRequest(): bool
    {
        try {
            return $this->environment->getPullRequestId() > 0;
        } catch (EnvironmentException) {
            return false;
        }
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        try {
            $repo = $this->environment->getRepo();
        } catch (EnvironmentException $e) {
            throw new FetchMergeRequestException(
                sprintf('Fetching repo information (repository, slug) was failed: %s', $e->getMessage()),
                previous: $e,
            );
        }

        try {
            $prId = $this->environment->getPullRequestId();
        } catch (EnvironmentException $e) {
            throw CurrentlyNotMergeRequestException::createFrom($e);
        }

        try {
            $pr = $this->client->getPullRequest(new PullRequestInput(
                $repo->workspace,
                $repo->slug,
                $prId,
            ));
        } catch (NotFoundException $e) {
            throw MergeRequestNotFoundException::create((string) $prId, $e->getMessage(), previous: $e);
        } catch (RequestException $e) {
            throw new FetchMergeRequestException(
                sprintf('Fetching pull request from bitbucket was failed: %s', $e->getMessage()),
                previous: $e,
            );
        }

        $description = Str::make($pr->description);

        return new MergeRequest(
            Str::make($pr->title),
            new Markdown($description),
            $this->markdownCleaner->clean($description),
            Set::fromList($this->labelsResolver->resolve($pr, $this->settings->labels)),
            false,
            Str::make($pr->sourceBranch),
            Str::make($pr->targetBranch),
            new Author(Str::make($pr->authorNickname)),
            $pr->isDraft(),
            $pr->canMerge(),
            $this->mapChanges($pr),
            $pr->createdAt,
            Str::make($pr->uri),
            (string) $pr->id,
            (string) $pr->id,
        );
    }

    /**
     * @return Map<string, Change>
     */
    private function mapChanges(PullRequest $request): Map
    {
        return new MapProxy(function () use ($request) {
            $changes = [];

            foreach ($request->changes as $filename => $diff) {
                $changes[$filename] = new \ArtARTs36\MergeRequestLinter\Domain\Request\Change(
                    $filename,
                    $diff,
                );
            }

            return new ArrayMap($changes);
        });
    }

    public function postCommentOnMergeRequest(MergeRequest $request, string $comment): void
    {
        try {
            $repo = $this->environment->getRepo();
        } catch (EnvironmentException $e) {
            throw new PostCommentException(
                sprintf('Fetch repository information was failed: %s', $e->getMessage()),
                previous: $e,
            );
        }

        try {
            $createdComment = $this->client->postComment(new CreateCommentInput(
                $repo->workspace,
                $repo->slug,
                (int)$request->id,
                $comment,
            ));
        } catch (RequestException $e) {
            throw new PostCommentException(
                sprintf('Post comment was failed: %s', $e->getMessage()),
                previous: $e,
            );
        }

        $this->logger->info(sprintf(
            '[BitbucketPipelines] Comment was created with id %d and url %s',
            $createdComment->id,
            $createdComment->url,
        ));
    }

    public function updateComment(Comment $comment): void
    {
        $repo = $this->environment->getRepo();
        $prId = $this->environment->getPullRequestId();

        $this->client->updateComment(new UpdateCommentInput(
            $repo->workspace,
            $repo->slug,
            $prId,
            $comment->id,
            $comment->message,
        ));

        $this->logger->info(sprintf(
            '[BitbucketPipelines] Comment with id "%s" was updated',
            $comment->id,
        ));
    }

    public function getFirstCommentOnMergeRequestByCurrentUser(MergeRequest $request): ?Comment
    {
        $repo = $this->environment->getRepo();
        $prId = $this->environment->getPullRequestId();

        $user = $this->client->getCurrentUser();

        $needComment = null;
        $page = 0;

        while ($needComment === null) {
            $comments = $this
                ->client
                ->getComments(new PullRequestInput(
                    $repo->workspace,
                    $repo->slug,
                    $prId,
                ));

            if ($comments->comments->isEmpty()) {
                break;
            }

            $needComment = $comments
                ->comments
                ->firstFilter(fn (API\Objects\Comment $comment) => $comment->authorAccountId === $user->accountId);

            ++$page;
        }

        return $needComment === null ? null : new Comment(
            (string) $needComment->id,
            $needComment->content,
        );
    }
}
