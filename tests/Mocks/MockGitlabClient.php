<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\CommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\GetCommentsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\Input;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

final class MockGitlabClient implements GitlabClient
{
    public function __construct(
        private readonly MergeRequest|\Throwable|null $getMergeRequestResponse = null,
        private readonly \Throwable|null $updateCommentResponse = null,
        private readonly \Throwable|null $postCommentResponse = null,
        private readonly Arrayee|\Throwable|null $getCommentsListResponse = null,
        private readonly User|\Throwable|null $getCurrentUserResponse = null,
    ) {
    }

    public function getMergeRequest(MergeRequestInput $input): MergeRequest
    {
        if ($this->getMergeRequestResponse === null) {
            throw new \Exception('Merge response request didnt set');
        }

        if ($this->getMergeRequestResponse instanceof MergeRequest) {
            return $this->getMergeRequestResponse;
        }

        throw $this->getMergeRequestResponse;
    }

    public function postComment(CommentInput $input): void
    {
        if ($this->postCommentResponse instanceof \Throwable) {
            throw $this->postCommentResponse;
        }
    }

    public function getCurrentUser(Input $input): User
    {
        if ($this->getCurrentUserResponse instanceof \Throwable) {
            throw $this->getCurrentUserResponse;
        }

        if ($this->getCurrentUserResponse instanceof User) {
            return $this->getCurrentUserResponse;
        }

        throw new \Exception('Get current user response no defined');
    }

    public function getCommentsOnMergeRequest(GetCommentsInput $input): Arrayee
    {
        if ($this->getCommentsListResponse instanceof \Throwable) {
            throw $this->getCommentsListResponse;
        }

        if ($this->getCommentsListResponse instanceof Arrayee) {
            return $this->getCommentsListResponse;
        }

        throw new \Exception('Get merge request response no defined');
    }

    public function updateComment(UpdateCommentInput $input): void
    {
        if ($this->updateCommentResponse instanceof \Throwable) {
            throw $this->updateCommentResponse;
        }
    }
}
