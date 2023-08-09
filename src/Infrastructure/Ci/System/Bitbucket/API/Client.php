<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\CreateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\CommentList;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\RequestException;

/**
 * Interface for Bitbucket Client.
 */
interface Client
{
    /**
     * Get pull request.
     * @throws RequestException
     */
    public function getPullRequest(PullRequestInput $input): PullRequest;

    /**
     * Get current user.
     * @throws RequestException
     */
    public function getCurrentUser(): User;

    /**
     * Get comments.
     * @throws RequestException
     */
    public function getComments(PullRequestInput $input): CommentList;

    /**
     * Update comment.
     * @throws RequestException
     */
    public function updateComment(UpdateCommentInput $input): Comment;

    /**
     * Post comment.
     * @throws RequestException
     */
    public function postComment(CreateCommentInput $input): Comment;
}
