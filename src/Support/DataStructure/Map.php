<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

/**
 * @template K of array-key
 * @template V
 * @template-extends ArrayCollection<K, V>
 */
class Map extends ArrayCollection
{
    use CountProxy;

    private ?int $count = null;

    /**
     * @param list<V> $list
     * @return Map<K, V>
     */
    public static function fromList(iterable $list): self
    {
        $items = [];
        $count = 0;

        foreach ($list as $item) {
            $items[$item] = $item;
            $count++;
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

    /**
     * @param V $value
     * @return string|null
     */
    public function search(mixed $value): ?string
    {
        foreach ($this as $key => $val) {
            if ($val === $value) {
                return $key;
            }
        }

        return null;
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

    /**
     * @return Map<V, array<K>>
     */
    public function groupKeysByValue(): Map
    {
        $groups = [];

        foreach ($this->items as $key => $value) {
            $groups[$value][] = $key;
        }

        return new Map($groups);
    }
}
