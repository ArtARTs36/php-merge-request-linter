<?php

namespace ArtARTs36\MergeRequestLinter\Common\DataStructure;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Common\Contracts\HasDebugInfo;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Traits\CountProxy;
use ArtARTs36\MergeRequestLinter\Common\Iterators\ArrayKeyIterator;

/**
 * @template V
 * @template-implements Collection<int, V>
 */
class Set implements Collection, HasDebugInfo
{
    use CountProxy;

    /**
     * @param array<V, true> $items
     */
    final public function __construct(protected array $items)
    {
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
    public function contains(mixed $value): bool
    {
        return array_key_exists($value, $this->items);
    }

    /**
     * @param iterable<V> $values
     */
    public function containsAny(iterable $values): bool
    {
        foreach ($values as $value) {
            if ($this->contains($value)) {
                return true;
            }
        }

        return false;
    }

    public function containsAll(iterable $values): bool
    {
        foreach ($values as $value) {
            if (! $this->contains($value)) {
                return false;
            }
        }

        return true;
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

    /**
     * @return \Traversable<V>
     */
    public function getIterator(): \Traversable
    {
        return new ArrayKeyIterator($this->items);
    }

    /**
     * @return V|null
     */
    public function first()
    {
        return array_key_first($this->items);
    }

    public function __debugInfo(): array
    {
        return [
            'count' => $this->count(),
            'items' => array_keys($this->items),
        ];
    }
}