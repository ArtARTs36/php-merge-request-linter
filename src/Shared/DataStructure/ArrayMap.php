<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits\ContainsAll;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits\CountProxy;

/**
 * @template K of array-key
 * @template V
 * @template-implements Map<K, V>
 */
final class ArrayMap implements Map
{
    use CountProxy;
    use ContainsAll;

    /**
     * @param array<K, V> $items
     */
    public function __construct(
        private readonly array $items,
    ) {
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
        return $this->search($value) !== null;
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

    /**
     * @return Arrayee<int, K>
     */
    public function keys(): Arrayee
    {
        return new Arrayee(array_keys($this->items));
    }

    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @param callable(K, V): mixed $mapper
     * @return array<K, mixed>
     */
    public function mapToArray(callable $mapper): array
    {
        $items = [];

        foreach ($this->items as $key => $value) {
            $items[] = $mapper($key, $value);
        }

        return $items;
    }

    public function __debugInfo(): array
    {
        return [
            'count' => $this->count(),
            'items' => $this->items,
        ];
    }
}
