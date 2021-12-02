<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
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
        private array $values
    ) {
        //
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
        return MergeRequest::fromArray([]);
    }
}
