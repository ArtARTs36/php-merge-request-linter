<?php

namespace ArtARTs36\MergeRequestLinter\Support;

/**
 * @template V
 * @template-extends ArrayCollection<V, bool>
 */
class Set extends ArrayCollection
{
    private ?int $count = null;

    /**
     * @param list<V> $list
     * @return Set<V, V>
     */
    public static function fromList(iterable $list): self
    {
        $items = [];
        $count = 0;

        foreach ($list as $item) {
            $items[$item] = true;
            $count++;
        }

        $set = new self($items);
        $set->count = $count;

        return $set;
    }

    /**
     * @param V $value
     */
    public function has(mixed $value): bool
    {
        return array_key_exists($value, $this->items);
    }

    public function count(): int
    {
        if ($this->count === null) {
            $this->count = count($this->items);
        }

        return $this->count;
    }

    public function diff(ArrayCollection $that): ArrayCollection
    {
        $items = $this->items;

        foreach ($that->items as $key => $_) {
            unset($items[$key]);
        }

        return new self($items);
    }

    public function getIterator(): \Traversable
    {
        return new ArrayKeyIterator($this->items);
    }
}
