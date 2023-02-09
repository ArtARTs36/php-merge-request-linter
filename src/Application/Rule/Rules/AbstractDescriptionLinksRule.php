<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

abstract class AbstractDescriptionLinksRule extends AbstractRule implements Rule
{
    /**
     * @param Set<string> $domains
     */
    final public function __construct(#[Generic(Generic::OF_STRING)] protected Set $domains)
    {
        //
    }
}
