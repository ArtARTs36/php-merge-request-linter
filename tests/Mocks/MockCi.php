<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
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
        #[ArrayShape([
            'is_pull_request' => 'bool',
        ])]
        private array $values,
        private ?MergeRequest $request = null,
    ) {
        //
    }

    public static function fromMergeRequest(MergeRequest $request): self
    {
        return new self([
            'is_pull_request' => 'true',
        ], $request);
    }

    public function getName(): string
    {
        return 'mock_ci';
    }

    public function isCurrentlyWorking(): bool
    {
        return true;
    }

    public function isCurrentlyMergeRequest(): bool
    {
       return $this->values['is_pull_request'];
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        return $this->request;
    }

    public function postCommentOnMergeRequest(MergeRequest $request, string $comment): void
    {
        //
    }

    public function getCommentsOnCurrentlyMergeRequests(): Arrayee
    {
        return new Arrayee([]);
    }
}
