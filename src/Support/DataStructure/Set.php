<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

use ArtARTs36\MergeRequestLinter\Support\ArrayKeyIterator;

/**
 * @template V
 * @template-implements \IteratorAggregate<V>
 */
class Set implements \Countable, \IteratorAggregate
{
    use CountProxy;

    private ?int $count = null;

    /**
     * @param array<V, bool> $items
     */
    public function __construct(
        private readonly array $items,
    ) {
        //
    }

    /**
     * @param list<V> $list
     * @return Set<V>
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

    /**
     * @param iterable<V> $values
     */
    public function hasAny(iterable $values): bool
    {
        foreach ($values as $value) {
            if ($this->has($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Set<V> $that
     * @return Set<V>
     */
    public function diff(Set $that): Set
    {
        $items = $this->items;

        foreach ($that->items as $key => $_) {
            unset($items[$key]);
        }

        //@phpstan-ignore-next-line
        return new self($items);
    }

    /**
     * @param Set<V> $set
     */
    public function equalsCount(Set $set): bool
    {
        return $this->count() === $set->count;
    }

    public function implode(string $separator): string
    {
        $items = $this->items;
        $str = '';

        foreach ($items as $val => $_) {
            $str .= $val;

            if (next($items) !== false) {
                $str .= $separator;
            }
        }

        return $str;
    }

    public function getIterator(): \Traversable
    {
        return new ArrayKeyIterator($this->items);
    }
}
