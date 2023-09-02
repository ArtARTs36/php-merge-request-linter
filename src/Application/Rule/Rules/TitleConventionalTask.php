<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

/**
 * @codeCoverageIgnore
 */
readonly class TitleConventionalTask
{
    /**
     * @param Arrayee<int, string> $projectCodes
     */
    public function __construct(
        #[Description('Project codes. Allowed empty list for any projects')]
        #[Generic(Generic::OF_STRING)]
        public Arrayee $projectCodes = new Arrayee([]),
    ) {
    }
}
