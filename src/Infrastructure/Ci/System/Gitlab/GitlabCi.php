<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FindCommentException;
use ArtARTs36\MergeRequestLinter\Domain\CI\InvalidCommentException;
use ArtARTs36\MergeRequestLinter\Domain\CI\MergeRequestNotFoundException;
use ArtARTs36\MergeRequestLinter\Domain\CI\PostCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\CommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\GetCommentsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\Input;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\RequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\NotFoundException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Str;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest as GitlabMergeRequest;

final readonly class GitlabCi implements CiSystem
{
    public const NAME = 'gitlab_ci';

    public function __construct(
        private GitlabEnvironment $environment,
        private GitlabClient      $client,
        private MarkdownCleaner   $markdownCleaner,
    ) {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function isCurrentlyWorking(): bool
    {
        return $this->environment->isWorking();
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        try {
            $requestNumber = $this->environment->getMergeRequestNumber();
        } catch (EnvironmentVariableNotFoundException $e) {
            throw CurrentlyNotMergeRequestException::createFrom($e);
        } catch (EnvironmentException $e) {
            throw new FetchMergeRequestException(
                sprintf('Failed to fetch merge request number: %s', $e->getMessage()),
                previous: $e,
            );
        }

        try {
            $serverUrl = $this->environment->getGitlabServerUrl();
        } catch (EnvironmentException $e) {
            throw new FetchMergeRequestException(sprintf(
                'Failed to fetch gitlab server url: %s',
                $e->getMessage()
            ), previous: $e);
        }

        try {
            $projectId = $this->environment->getProjectId();
        } catch (EnvironmentException $e) {
            throw new FetchMergeRequestException(sprintf(
                'Failed to fetch gitlab project id: %s',
                $e->getMessage(),
            ), previous: $e);
        }

        try {
            $request = $this->client->getMergeRequest(
                new MergeRequestInput(
                    $serverUrl,
                    $projectId,
                    $requestNumber,
                ),
            );
        } catch (NotFoundException $e) {
            throw new MergeRequestNotFoundException($e->getMessage(), previous: $e);
        } catch (RequestException $e) {
            throw new FetchMergeRequestException($e->getMessage(), previous: $e);
        }

        $description = Str::make($request->description);

        return new MergeRequest(
            Str::make($request->title),
            $description->markdown(),
            $this->markdownCleaner->clean($description),
            Set::fromList($request->labels),
            $request->hasConflicts,
            Str::make($request->sourceBranch),
            Str::make($request->targetBranch),
            new Author(Str::make($request->authorLogin)),
            $request->isDraft,
            $request->canMerge(),
            $this->mapChanges($request),
            $request->createdAt,
            Str::make($request->uri),
            (string) $request->id,
            (string) $request->number,
        );
    }

    /**
     * @return Map<string, Change>
     */
    private function mapChanges(GitlabMergeRequest $request): Map
    {
        $changes = [];

        foreach ($request->changes as $change) {
            $changes[$change->newPath] = new Change(
                $change->newPath,
                $change->diff,
            );
        }

        return new ArrayMap($changes);
    }

    public function postCommentOnMergeRequest(MergeRequest $request, string $comment): void
    {
        try {
            $this->client->postComment(
                new CommentInput(
                    $this->environment->getGitlabServerUrl(),
                    $this->environment->getProjectId(),
                    (int) $request->number,
                    $comment,
                ),
            );
        } catch (EnvironmentException $e) {
            throw new PostCommentException(sprintf(
                'Fetch repository information was failed: %s',
                $e->getMessage(),
            ), previous: $e);
        } catch (RequestException $e) {
            throw new PostCommentException(sprintf(
                'Send comment to GitLab was failed: %s',
                $e->getMessage(),
            ), previous: $e);
        }
    }

    public function updateComment(Comment $comment): void
    {
        if (! is_numeric($comment->id)) {
            throw new InvalidCommentException(sprintf(
                'Comment id for GitLab CI must be integer. Given string: %s',
                $comment->id,
            ));
        }

        $commentId = (int) $comment->id;

        try {
            $this->client->updateComment(
                new UpdateCommentInput(
                    $this->environment->getGitlabServerUrl(),
                    $this->environment->getProjectId(),
                    $this->environment->getMergeRequestNumber(),
                    $comment->message,
                    $commentId,
                ),
            );
        } catch (EnvironmentException $e) {
            throw new PostCommentException(sprintf(
                'Fetch repository information was failed: %s',
                $e->getMessage(),
            ), previous: $e);
        } catch (RequestException $e) {
            throw new PostCommentException(sprintf(
                'Send comment to GitLab was failed: %s',
                $e->getMessage(),
            ), previous: $e);
        }
    }

    public function getFirstCommentOnMergeRequestByCurrentUser(MergeRequest $request): ?Comment
    {
        try {
            $serverUrl = $this->environment->getGitlabServerUrl();
        } catch (EnvironmentException $e) {
            throw new FindCommentException(sprintf(
                'Failed to fetch gitlab server url: %s',
                $e->getMessage()
            ), previous: $e);
        }

        try {
            $projectId = $this->environment->getProjectId();
        } catch (EnvironmentException $e) {
            throw new FindCommentException(sprintf(
                'Fetch project id was failed: %s',
                $e->getMessage(),
            ), previous: $e);
        }

        try {
            $user = $this->client->getCurrentUser(new Input(
                $serverUrl,
            ));
        } catch (RequestException $e) {
            throw new FindCommentException(
                sprintf('Fetch current user was failed: %s', $e->getMessage()),
                previous: $e,
            );
        }

        try {
            $gitlabComment = $this
                ->client
                ->getCommentsOnMergeRequest(new GetCommentsInput(
                    $serverUrl,
                    $projectId,
                    $request->number,
                ))
                ->firstFilter(fn (API\Objects\Comment $comment) => $comment->authorLogin === $user->login);
        } catch (RequestException $e) {
            throw new FindCommentException(sprintf(
                'Fetch comment list from gitlab was failed: %s',
                $e->getMessage(),
            ), previous: $e);
        }

        return $gitlabComment === null ? null : new Comment(
            (string) $gitlabComment->id,
            $gitlabComment->body,
            $request->id,
        );
    }
}
