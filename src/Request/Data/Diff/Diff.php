<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data\Diff;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

/**
 * @template-extends Arrayee<int, Line>
 */
class Diff extends Arrayee
{
    public function hasChangeByContentContains(string $content, bool $regex = false): bool
    {
        foreach ($this->items as $item) {
            if ($item->hasChanges() && $item->content->contains($content, $regex)) {
                return true;
            }
        }

        return false;
    }

    public function hasChangeByContentContainsByRegex(string $content): bool
    {
        foreach ($this->items as $item) {
            if ($item->hasChanges() && $item->content->match($content)->isNotEmpty()) {
                return true;
            }
        }

        return false;
    }
}
