<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

/**
 * @template K of array-key
 * @template V
 * @template-implements Collection<K, V>
 */
class Map implements Collection
{
    use CountProxy;

    /**
     * @param array<K, V> $items
     */
    public function __construct(protected array $items)
    {
        //
    }


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

        $map = new self($items);
        $map->count = $count;

        return $map;
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
     * @return Map<K, array<V>>
     */
    public function groupKeysByValue(): Map
    {
        $groups = [];

        foreach ($this->items as $key => $value) {
            $groups[$value][] = $key;
        }

        return new Map($groups);
    }

    public function containsAny(iterable $values): bool
    {
        $valueMap = [];

        foreach ($values as $value) {
            $valueMap[$value] = true;
        }

        foreach ($this as $item) {
            if (isset($valueMap[$item])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Map<K, V> $that
     * @return Map<K, V>
     */
    public function diff(self $that): self
    {
        return new self(array_diff($this->items, $that->items));
    }

    /**
     * @return \Traversable<K, V>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @return V|null
     */
    public function first()
    {
        return $this->items[array_key_first($this->items)] ?? null;
    }

    public function implode(string $sep): string
    {
        return implode($sep, $this->items);
    }
}
