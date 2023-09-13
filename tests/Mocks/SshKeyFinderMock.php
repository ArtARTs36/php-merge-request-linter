<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\SshKeyFinder;
use ArtARTs36\Str\Str;

final class SshKeyFinderMock implements SshKeyFinder
{
    /**
     * @param array<string, array<string>> $types
     */
    public function __construct(
        private readonly array $types,
    ) {
    }

    public function findFirst(Str $text): ?string
    {
        return $this->types[$text->__toString()][0] ?? null;
    }

    public function findAll(Str $text): array
    {
        return $this->types[$text->__toString()] ?? [];
    }
}
