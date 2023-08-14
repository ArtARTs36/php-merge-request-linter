<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

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
        private readonly MergeRequest|\Throwable|null $getMergeRequestResponse = ull,
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
        // TODO: Implement postComment() method.
    }

    public function getCurrentUser(Input $input): User
    {
        // TODO: Implement getCurrentUser() method.
    }

    public function getCommentsOnMergeRequest(GetCommentsInput $input): Arrayee
    {
        // TODO: Implement getCommentsOnMergeRequest() method.
    }

    public function updateComment(UpdateCommentInput $input): void
    {
        // TODO: Implement updateComment() method.
    }
}
