<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * @codeCoverageIgnore
 */
class TagsHeadingRegex
{
    public function __construct(
        #[Description('Regex expression for match tags')]
        public readonly string $expression,
        #[Description('Example for need tag title')]
        public readonly ?string $example,
    ) {
        //
    }
}
