<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\SshKeyFinder;
use ArtARTs36\Str\Str;

final class SshKeyFinderMock implements SshKeyFinder
{
    /**
     * @param array<string> $types
     */
    public function __construct(
        private readonly array $types,
    ) {
    }

    public function find(Str $text, bool $stopOnFirst): array
    {
        return $this->types;
    }
}
