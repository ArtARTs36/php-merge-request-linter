<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data\Diff;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

/**
 * @template-extends Arrayee<int, Line>
 */
class Diff extends Arrayee
{
    /**
     * @return array<Line>
     */
    public function searchChangeByContentContains(string $content, bool $regex = false): array
    {
        $lines = [];

        foreach ($this->items as $item) {
            if ($item->hasChanges() && $item->content->contains($content, $regex)) {
                $lines[] = $item;
            }
        }

        return $lines;
    }

    public function hasChangeByContentContains(string $content, bool $regex = false): bool
    {
        return count($this->searchChangeByContentContains($content, $regex)) > 0;
    }
}
