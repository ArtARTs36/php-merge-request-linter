<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Support\Map;

abstract class AbstractLabelsRule extends AbstractRule implements Rule
{
    /**
     * @param Map<string, string> $labels
     */
    final public function __construct(protected Map $labels)
    {
        //
    }

    /**
     * @param iterable<string> $labels
     */
    public static function make(iterable $labels): self
    {
        return new static(Map::fromList($labels));
    }
}
