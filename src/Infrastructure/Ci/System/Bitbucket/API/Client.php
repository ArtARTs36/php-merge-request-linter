<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\CreateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\CommentList;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\User;

/**
 * Interface for Client.
 */
interface Client
{
    /**
     * Get pull request.
     */
    public function getPullRequest(PullRequestInput $input): PullRequest;

    /**
     * Get current user.
     */
    public function getCurrentUser(): User;

    /**
     * Get comments.
     */
    public function getComments(PullRequestInput $input): CommentList;

    /**
     * Update comment.
     */
    public function updateComment(UpdateCommentInput $input): Comment;

    /**
     * Post comment.
     */
    public function postComment(CreateCommentInput $input): Comment;
}
