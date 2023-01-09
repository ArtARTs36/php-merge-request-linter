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
        foreach ($this->items as $item) {
            if ($item->hasChanges() && $item->content->contains($content, $regex)) {
                return true;
            }
        }

        return false;
    }

    public function __toString(): string
    {
        $json = json_encode(array_map(function (Line $line) {
            return $line->content->cut(50);
        }, $this->items));

        return $json === false ? '' : $json;
    }
}
