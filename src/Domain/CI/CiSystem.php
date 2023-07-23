<?php

namespace ArtARTs36\MergeRequestLinter\Domain\CI;

use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Continuous Integration System.
 */
interface CiSystem
{
    /**
     * Get CI System Name.
     */
    public function getName(): string;

    /**
     * Is currently CiSystem.
     */
    public function isCurrentlyWorking(): bool;

    /**
     * Is Merge Request.
     */
    public function isCurrentlyMergeRequest(): bool;

    /**
     * Get current merge request.
     * @throws GettingMergeRequestException
     */
    public function getCurrentlyMergeRequest(): MergeRequest;

    /**
     * Post comment on merge request.
     * @throws PostCommentException
     */
    public function postCommentOnMergeRequest(MergeRequest $request, string $comment): void;

    /**
     * Update comment.
     * @throws InvalidCommentException
     */
    public function updateComment(Comment $comment): void;

    /**
     * Get first comment on merge request by current user.
     */
    public function getFirstCommentOnMergeRequestByCurrentUser(MergeRequest $request): ?Comment;
}
