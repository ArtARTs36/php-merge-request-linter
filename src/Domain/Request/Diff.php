<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\Str\Exceptions\InvalidRegexException;

/**
 * @template-extends Arrayee<int, DiffLine>
 */
class Diff extends Arrayee
{
    public function hasChangeByContentContains(string $content): bool
    {
        foreach ($this->items as $item) {
            if ($item->hasChanges() && $item->content->contains($content)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws InvalidRegexException
     */
    public function hasChangeByContentContainsByRegex(string $regex): bool
    {
        foreach ($this->items as $item) {
            if ($item->hasChanges() && $item->content->match($regex)->isNotEmpty()) {
                return true;
            }
        }

        return false;
    }
}
