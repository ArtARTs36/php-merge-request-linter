<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

abstract class AbstractLabelsRule extends AbstractRule implements Rule
{
    /**
     * @param Set<string> $labels
     */
    final public function __construct(protected Set $labels)
    {
        //
    }

    /**
     * @param iterable<string> $labels
     */
    public static function make(iterable $labels): self
    {
        return new static(Set::fromList($labels));
    }
}
