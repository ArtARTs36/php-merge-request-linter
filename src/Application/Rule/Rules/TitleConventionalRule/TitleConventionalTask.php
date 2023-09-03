<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
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
        #[Description('Project codes. Empty list allowed for any projects')]
        #[Generic(Generic::OF_STRING)]
        #[Example('ABC')]
        public Arrayee $projectCodes = new Arrayee([]),
    ) {
    }
}
