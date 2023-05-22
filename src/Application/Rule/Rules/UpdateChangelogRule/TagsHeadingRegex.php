<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;

class TagsHeadingRegex
{
    public function __construct(
        public readonly string $expression,
        public readonly ?string $example,
    ) {
        //
    }
}
