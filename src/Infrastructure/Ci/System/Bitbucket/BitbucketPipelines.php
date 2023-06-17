<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\CreateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\LabelsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\BitbucketPipelinesSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
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
        private readonly Client $client,
        private readonly BitbucketEnvironment $environment,
        private readonly MarkdownCleaner $markdownCleaner,
        private readonly BitbucketPipelinesSettings $settings,
        private readonly LabelsResolver $labelsResolver,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

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
        } catch (EnvironmentVariableNotFoundException) {
            return false;
        }
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        $repo = $this->environment->getRepo();
        $prId = $this->environment->getPullRequestId();

        $pr = $this->client->getPullRequest(new PullRequestInput(
            $repo->workspace,
            $repo->slug,
            $prId,
        ));

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
                    new Diff($diff),
                );
            }

            return new ArrayMap($changes);
        });
    }

    public function postCommentOnMergeRequest(MergeRequest $request, string $comment): void
    {
        $repo = $this->environment->getRepo();
        $prId = $this->environment->getPullRequestId();

        $createdComment = $this->client->postComment(new CreateCommentInput(
            $repo->workspace,
            $repo->slug,
            $prId,
            $comment,
        ));

        $this->logger->info(sprintf(
            '[BitbucketPipelines] Comment was created with id %d and url %s',
            $createdComment->id,
            $createdComment->url,
        ));
    }

    public function updateComment(Comment $comment): void
    {
        // TODO: Implement updateComment() method.
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
            $needComment->id,
            $needComment->content,
        );
    }
}
