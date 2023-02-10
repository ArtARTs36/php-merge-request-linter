<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Common\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Set;
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
