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

    /**
     * @return T|null
     */
    public function get(string $id)
    {
        return $this->items[$id] ?? null;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->items);
    }

    public function missing(string $id): bool
    {
        return ! $this->has($id);
    }
}
