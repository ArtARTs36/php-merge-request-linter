<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;

abstract class AbstractLabelsRule extends AbstractRule implements Rule
{
    /**
     * @param Set<string> $labels
     */
    final public function __construct(#[Generic(Generic::OF_STRING)] protected Set $labels)
    {
        //
    }
}
