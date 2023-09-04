<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule;

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
