<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * @codeCoverageIgnore
 */
readonly class Tags
{
    public function __construct(
        #[Description('Headings parse options')]
        public TagsHeading $heading,
    ) {
        //
    }
}
