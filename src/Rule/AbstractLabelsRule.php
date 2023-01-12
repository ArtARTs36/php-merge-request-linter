<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

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
