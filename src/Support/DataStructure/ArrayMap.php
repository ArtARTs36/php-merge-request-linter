<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Traits\ContainsAll;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Traits\CountProxy;

/**
 * @template K of array-key
 * @template V
 * @template-implements Map<K, V>
 */
class ArrayMap implements Map
{
    use CountProxy;
    use ContainsAll;

    /**
     * @param array<K, V> $items
     */
    public function __construct(
        private readonly array $items,
    ) {
        //
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

    public function contains(mixed $value): bool
    {
        return $this->search($value) === null;
    }

    public function missing(string $id): bool
    {
        return ! $this->has($id);
    }

    /**
     * @param ArrayMap<K, V> $that
     */
    public function equals(ArrayMap $that): bool
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
     * @return ArrayMap<K, array<V>>
     */
    public function groupKeysByValue(): ArrayMap
    {
        $groups = [];

        foreach ($this->items as $key => $value) {
            $groups[$value][] = $key;
        }

        /** @phpstan-ignore-next-line */
        return new ArrayMap($groups);
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
     * @param ArrayMap<K, V> $that
     * @return ArrayMap<K, V>
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

    /**
     * @return Arrayee<int, K>
     */
    public function keys(): Arrayee
    {
        return new Arrayee(array_keys($this->items));
    }

    public function debugView(): string
    {
        $json = json_encode($this->items);

        return $json === false ? '' : $json;
    }
}
