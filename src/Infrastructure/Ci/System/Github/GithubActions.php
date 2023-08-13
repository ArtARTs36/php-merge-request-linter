<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\MergeRequestNotFoundException;
use ArtARTs36\MergeRequestLinter\Domain\CI\PostCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidEnvironmentVariableValueException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidResponseException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\NotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\RequestException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Str;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class GithubActions implements CiSystem
{
    public const NAME = 'github_actions';

    public function __construct(
        private readonly GithubEnvironment $env,
        private readonly GithubClient $client,
        private readonly LoggerInterface $logger = new NullLogger(),
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
        return $this->env->isWorking();
    }

    public function isCurrentlyMergeRequest(): bool
    {
        try {
            return $this->env->getMergeRequestId() !== null;
        } catch (EnvironmentException) {
            return false;
        }
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        $requestId = $this->env->getMergeRequestId();

        if ($requestId === null) {
            throw new CurrentlyNotMergeRequestException();
        }

        try {
            $graphqlUrl = $this->env->getGraphqlURL();
            $repo = $this->env->extractRepo();
        } catch (EnvironmentException|InvalidEnvironmentVariableValueException $e) {
            throw new FetchMergeRequestException($e->getMessage(), previous: $e);
        }

        try {
            $pullRequest = $this->client->getPullRequest(new PullRequestInput(
                $graphqlUrl,
                $repo->owner,
                $repo->name,
                $requestId,
            ));
        } catch (NotFoundException $e) {
            throw new MergeRequestNotFoundException($e->getMessage(), previous: $e);
        } catch (RequestException $e) {
            throw new FetchMergeRequestException($e->getMessage(), previous: $e);
        }

        return new MergeRequest(
            Str::make($pullRequest->title),
            Str::make($pullRequest->bodyMarkdown)->markdown(),
            Str::make($pullRequest->bodyText),
            Set::fromList($pullRequest->labels),
            $pullRequest->hasConflicts(),
            Str::make($pullRequest->headRefName),
            Str::make($pullRequest->baseRefName),
            new Author(Str::make($pullRequest->authorLogin)),
            $pullRequest->isDraft,
            $pullRequest->canMerge(),
            $this->mapChanges($pullRequest),
            $pullRequest->createdAt,
            Str::make($pullRequest->uri),
            $pullRequest->id,
        );
    }

    /**
     * @return Map<string, \ArtARTs36\MergeRequestLinter\Domain\Request\Change>
     */
    private function mapChanges(PullRequest $request): Map
    {
        return new MapProxy(function () use ($request) {
            $changes = [];

            foreach ($request->changes as $change) {
                $changes[$change->filename] = new \ArtARTs36\MergeRequestLinter\Domain\Request\Change(
                    $change->filename,
                    $change->diff,
                );
            }

            return new ArrayMap($changes);
        }, $request->changedFiles);
    }

    public function postCommentOnMergeRequest(MergeRequest $request, string $comment): void
    {
        try {
            $this->client->postComment(
                new AddCommentInput($this->env->getGraphqlURL(), $request->id, $comment),
            );
        } catch (InvalidResponseException $e) {
            throw new PostCommentException(sprintf(
                'Post comment was failed: %s',
                $e->getMessage(),
            ), previous: $e);
        }
    }

    public function updateComment(Comment $comment): void
    {
        $this->client->updateComment(
            new UpdateCommentInput($this->env->getGraphqlURL(), $comment->id, $comment->message),
        );
    }

    public function getFirstCommentOnMergeRequestByCurrentUser(MergeRequest $request): ?Comment
    {
        $user = $this->client->getCurrentUser($this->env->getGraphqlURL());

        $this->logger->debug(sprintf(
            '[GithubActions] Current user is "%s"',
            $user->getHiddenLogin(),
        ));

        $gComment = $this->findCommentByUser($request, $user->login);

        return $gComment === null ? null : new Comment(
            $gComment->id,
            $gComment->message,
        );
    }

    private function findCommentByUser(MergeRequest $request, string $userLogin): ?API\GraphQL\Type\Comment
    {
        $gComment = null;
        $after = null;

        while ($gComment === null) {
            $commentList = $this
                ->client
                ->getCommentsOnPullRequest(
                    $this->env->getGraphqlURL(),
                    $request->uri,
                    $after,
                );

            if ($commentList->comments->isEmpty()) {
                break;
            }

            $gComment = $commentList
                ->comments
                ->firstFilter(fn (API\GraphQL\Type\Comment $comment) => $comment->authorLogin === $userLogin);

            if ($gComment !== null || ! $commentList->hasNextPage) {
                break;
            }

            $after = $commentList->endCursor;
        }

        return $gComment;
    }
}
