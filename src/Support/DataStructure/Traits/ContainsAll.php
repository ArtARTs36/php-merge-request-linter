<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure\Traits;

trait ContainsAll
{
    public function containsAll(iterable $values): bool
    {
        $valueMap = [];

        foreach ($values as $k => $v) {
            $valueMap[$v] = $k;
        }

        foreach ($this->items as $item) {
            unset($valueMap[$item]);
        }

        return count($valueMap) === 0;
    }
}
