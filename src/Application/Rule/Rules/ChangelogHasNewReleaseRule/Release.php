<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule;

/**
 * @codeCoverageIgnore
 */
class Release
{
    /**
     * @param array<ReleaseChanges> $changes
     */
    public function __construct(
        public string $title,
        public string $tag,
        public array  $changes,
    ) {
    }
}
