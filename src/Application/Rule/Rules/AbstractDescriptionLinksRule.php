<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;

abstract class AbstractDescriptionLinksRule extends AbstractRule implements Rule
{
    /**
     * @param Set<string> $domains
     */
    final public function __construct(
        #[Description('Array of domains')]
        #[Generic(Generic::OF_STRING)]
        #[Example('host.name')]
        protected readonly Set $domains,
    ) {
        //
    }
}
