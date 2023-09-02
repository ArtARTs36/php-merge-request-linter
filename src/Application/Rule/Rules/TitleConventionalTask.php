<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;

/**
 * @codeCoverageIgnore
 */
readonly class TitleConventionalTask
{
    /**
     * @param array<string> $projectCodes
     */
    public function __construct(
        #[Generic(Generic::OF_STRING)]
        public array $projectCodes = [],
    ) {
    }
}
