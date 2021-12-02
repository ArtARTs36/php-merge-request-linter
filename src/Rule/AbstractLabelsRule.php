<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Support\Map;

abstract class AbstractLabelsRule implements Rule
{
    final public function __construct(protected Map $labels)
    {
        //
    }

    /**
     * @param array<string> $labels
     */
    public static function make(array $labels): self
    {
        return new static(Map::fromList($labels));
    }
}
