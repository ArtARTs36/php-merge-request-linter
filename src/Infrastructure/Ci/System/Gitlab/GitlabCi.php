<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\CommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\GetCommentsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\Input;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Str;

class GitlabCi implements CiSystem
{
    public const NAME = 'gitlab_ci';

    public function __construct(
        protected GitlabEnvironment     $environment,
        protected GitlabClient          $client,
        protected MarkdownCleaner $markdownCleaner,
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
            return $this->environment->getMergeRequestNumber() >= 0;
        } catch (EnvironmentVariableNotFoundException) {
            return false;
        }
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        $request = $this->client->getMergeRequest(
            new MergeRequestInput(
                $this->environment->getGitlabServerUrl(),
                $this->environment->getProjectId(),
                $this->environment->getMergeRequestNumber(),
            ),
        );

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
    private function mapChanges(API\Objects\MergeRequest $request): Map
    {
        $changes = [];

        foreach ($request->changes as $change) {
            $changes[$change->newPath] = new Change(
                $change->newPath,
                new Diff($change->diff),
            );
        }

        return new ArrayMap($changes);
    }

    public function postCommentOnMergeRequest(MergeRequest $request, string $comment): void
    {
        $this->client->postComment(
            new CommentInput(
                $this->environment->getGitlabServerUrl(),
                $this->environment->getProjectId(),
                $this->environment->getMergeRequestNumber(),
                $comment,
            ),
        );
    }

    public function updateComment(Comment $comment): void
    {
        $this->client->updateComment(
            new UpdateCommentInput(
                $this->environment->getGitlabServerUrl(),
                $this->environment->getProjectId(),
                $this->environment->getMergeRequestNumber(),
                $comment->message,
                $comment->id,
            ),
        );
    }

    public function getFirstCommentOnMergeRequestByCurrentUser(MergeRequest $request): ?Comment
    {
        $user = $this->client->getCurrentUser(new Input(
            $this->environment->getGitlabServerUrl(),
        ));

        $gitlabComment = $this
            ->client
            ->getCommentsOnMergeRequest(new GetCommentsInput(
                $this->environment->getGitlabServerUrl(),
                $this->environment->getProjectId(),
                $request->number,
            ))
            ->firstFilter(fn (API\Objects\Comment $comment) => $comment->authorLogin === $user->login);

        return $gitlabComment === null ? null : new Comment(
            $gitlabComment->id,
            $gitlabComment->body,
        );
    }
}
