<?php

namespace ArtARTs36\MergeRequestLinter\Support;

/**
 * @template K of array-key
 * @template V
 * @template-extends ArrayCollection<K, V>
 */
class Map extends ArrayCollection
{
    /**
     * @param list<V> $list
     * @return Map<K, V>
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
     * @return V|null
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

    /**
     * @param Map<K, V> $that
     */
    public function equals(Map $that): bool
    {
        if (! $this->equalsCount($that)) {
            return false;
        }

        foreach ($this as $key => $value) {
            if (! $that->has($key) || $that->get($key) !== $value) {
                return false;
            }
        }

        return true;
    }
}
