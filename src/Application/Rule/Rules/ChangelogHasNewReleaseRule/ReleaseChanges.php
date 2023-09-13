<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule;

use ArtARTs36\Str\Str;

/**
 * @codeCoverageIgnore
 */
final readonly class ReleaseChanges
{
    /**
     * @param array<Str> $changes
     */
    public function __construct(
        public string $type,
        public array $changes,
    ) {
    }
}
