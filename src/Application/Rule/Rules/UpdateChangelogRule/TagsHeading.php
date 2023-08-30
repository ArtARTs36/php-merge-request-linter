<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Text\Markdown\HeadingLevel;

/**
 * @codeCoverageIgnore
 */
readonly class TagsHeading
{
    public function __construct(
        #[Description('Markdown heading level for tags')]
        public HeadingLevel $level = HeadingLevel::Level2,
    ) {
        //
    }
}
