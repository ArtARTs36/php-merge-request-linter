<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use JetBrains\PhpStorm\ArrayShape;

final class MockCi implements CiSystem
{
    /**
     * @param array<string, bool|string> $values
     */
    public function __construct(
        private ?MergeRequest $request = null,
    ) {
        //
    }

    public function getName(): string
    {
        return 'mock_ci';
    }

    public function isCurrentlyWorking(): bool
    {
        return true;
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        if ($this->request === null) {
            throw CurrentlyNotMergeRequestException::create();
        }

        return $this->request;
    }

    public function postCommentOnMergeRequest(MergeRequest $request, string $comment): void
    {
        //
    }

    public function updateComment(Comment $comment): void
    {
        //
    }

    public function getFirstCommentOnMergeRequestByCurrentUser(MergeRequest $request): ?Comment
    {
        return null;
    }
}
