<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * @codeCoverageIgnore
 */
class TagsHeading
{
    public function __construct(
        #[Description('Markdown heading level for tags')]
        public readonly int $level = 2,
        public readonly ?TagsHeadingRegex $regex = null,
    ) {
        //
    }
}
