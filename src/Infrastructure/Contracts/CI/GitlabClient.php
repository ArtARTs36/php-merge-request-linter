<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\CommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\GetCommentsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\Input;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

/**
 * Interface for GitLab Client.
 */
interface GitlabClient
{
    /**
     * Get Merge Request.
     */
    public function getMergeRequest(MergeRequestInput $input): MergeRequest;

    /**
     * Post comment.
     */
    public function postComment(CommentInput $input): void;

    /**
     * Get current user.
     */
    public function getCurrentUser(Input $input): User;

    /**
     * Get comments on merge request.
     * @return Arrayee<int, Comment>
     */
    public function getCommentsOnMergeRequest(GetCommentsInput $input): Arrayee;

    /**
     * Update comment.
     */
    public function updateComment(UpdateCommentInput $input): void;
}
