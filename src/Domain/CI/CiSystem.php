<?php

namespace ArtARTs36\MergeRequestLinter\Domain\CI;

use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;

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

    public function updateComment(Comment $comment): void;

    public function getFirstCommentOnMergeRequestByCurrentUser(MergeRequest $request): ?Comment;
}
