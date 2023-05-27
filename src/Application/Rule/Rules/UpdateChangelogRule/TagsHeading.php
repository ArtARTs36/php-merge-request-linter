<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Text\Markdown\HeadingLevel;

/**
 * @codeCoverageIgnore
 */
class TagsHeading
{
    public function __construct(
        #[Description('Markdown heading level for tags')]
        public readonly HeadingLevel $level = HeadingLevel::Level2,
        public readonly ?TagsHeadingRegex $regex = null,
    ) {
        //
    }
}
