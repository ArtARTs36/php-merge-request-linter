<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;

class TagsHeading
{
    public function __construct(
        public readonly int $level = 2,
        public readonly ?TagsHeadingRegex $regex = null,
    ) {
        //
    }
}
