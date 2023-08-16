<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\CreateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\CommentList;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\User;

final class MockBitbucketClient implements Client
{
    public function __construct(
        private readonly PullRequest|\Throwable|\Closure|null $getPullRequest = null,
        private readonly \Throwable|Comment|null $postCommentResponse = null,
        private readonly \Throwable|Comment|null $updateCommentResponse = null,
    ) {
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        if ($this->getPullRequest instanceof PullRequest) {
            return $this->getPullRequest;
        }

        if ($this->getPullRequest instanceof \Throwable) {
            throw $this->getPullRequest;
        }

        return ($this->getPullRequest)();
    }

    public function getCurrentUser(): User
    {
        // TODO: Implement getCurrentUser() method.
    }

    public function getComments(PullRequestInput $input): CommentList
    {
        // TODO: Implement getComments() method.
    }

    public function updateComment(UpdateCommentInput $input): Comment
    {
        if ($this->updateCommentResponse instanceof \Throwable) {
            throw $this->updateCommentResponse;
        }

        return $this->updateCommentResponse;
    }

    public function postComment(CreateCommentInput $input): Comment
    {
        if ($this->postCommentResponse instanceof \Throwable) {
            throw $this->postCommentResponse;
        }

        return $this->postCommentResponse;
    }
}
