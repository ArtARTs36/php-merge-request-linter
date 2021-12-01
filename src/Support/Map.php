<?php

namespace ArtARTs36\MergeRequestLinter\Support;

/**
 * @template T
 */
class Map extends Collection
{
    /**
     * @param list<T> $list
     */
    public static function fromList(iterable $list): self
    {
        $items = [];

        foreach ($list as $item) {
            $items[$item] = $item;
        }

        return new self($items);
    }

    public function has(string $label): bool
    {
        return array_key_exists($label, $this->items);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function count(): int
    {
        return count($this->items);
    }
}
