<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

/**
 * @template-extends Arrayee<int, DiffLine>
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
