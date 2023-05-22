<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;

class Tags
{
    public function __construct(
        public readonly TagsHeading $heading,
    ) {
        //
    }
}
