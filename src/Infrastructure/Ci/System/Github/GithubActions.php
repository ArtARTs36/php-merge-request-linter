<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\PostCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidResponseException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Str;

final class GithubActions implements CiSystem
{
    public const NAME = 'github_actions';

    public function __construct(
        private readonly GithubEnvironment $env,
        private readonly GithubClient $client,
    ) {
        //
    }

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
        return $this->env->getMergeRequestId() !== null;
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        $requestId = $this->env->getMergeRequestId();

        if ($requestId === null) {
            throw new CurrentlyNotMergeRequestException();
        }

        $graphqlUrl = $this->env->getGraphqlURL();
        $repo = $this->env->extractRepo();

        $pullRequest = $this->client->getPullRequest(new PullRequestInput(
            $graphqlUrl,
            $repo->owner,
            $repo->name,
            $requestId,
        ));

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
                    new Diff($change->diff),
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

        $gComment = $this
            ->client
            ->getCommentsOnPullRequest(
                $this->env->getGraphqlURL(),
                $request->uri,
            )
            ->firstFilter(fn (API\GraphQL\Type\Comment $comment) => $comment->authorLogin === $user->login);

        return $gComment === null ? null : new Comment(
            $gComment->id,
            $gComment->message,
        );
    }
}
