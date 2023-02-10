<?php

namespace ArtARTs36\MergeRequestLinter\Common\DataStructure\Traits;

trait ContainsAll
{
    public function containsAll(iterable $values): bool
    {
        $valueMap = [];

        foreach ($values as $k => $v) {
            $valueMap[$v] = $k;
        }

        $valuesCount = count($valueMap);
        $founded = 0;

        foreach ($this->items as $item) {
            if (isset($valueMap[$item])) {
                $founded++;
            }

            if ($founded === $valuesCount) {
                return true;
            }
        }

        return false;
    }
}
