<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
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

    public static function is(Environment $environment): bool
    {
        return true;
    }

    public function isMergeRequest(): bool
    {
       return $this->values['is_pull_request'];
    }

    public function getMergeRequest(): MergeRequest
    {
        return $this->request ?? MergeRequest::fromArray([]);
    }
}
