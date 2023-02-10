<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Common\Contracts\HasDebugInfo;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Traits\ContainsAll;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Traits\CountProxy;
use Traversable;

/**
 * @template K of array-key
 * @template V
 * @template-implements Collection<K, V>
 */
class Arrayee implements Collection, HasDebugInfo
{
    use CountProxy;
    use ContainsAll;

    /**
     * @param array<K, V> $items
     */
    public function __construct(
        protected array $items,
    ) {
        //
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function containsAny(iterable $values): bool
    {
        foreach ($values as $value) {
            if ($this->contains($value)) {
                return true;
            }
        }

        return false;
    }

    public function contains(mixed $value): bool
    {
        return in_array($value, $this->items);
    }

    /**
     * @return V|null
     */
    public function first(): mixed
    {
        $item = current($this->items);

        if ($item === false) {
            return null;
        }

        return $item;
    }

    public function implode(string $sep): string
    {
        return implode($sep, $this->items);
    }

    /**
     * @param callable(V): mixed $mapper
     * @return array<mixed>
     */
    public function mapToArray(callable $mapper): array
    {
        return array_map($mapper, $this->items);
    }

    /**
     * @param Arrayee<K, V>|array<K, V> $that
     * @return Arrayee<K, V>
     */
    public function merge(Arrayee|array $that): Arrayee
    {
        $items = is_array($that) ? $that : $that->items;

        return new Arrayee(array_merge($this->items, $items));
    }

    public function __debugInfo(): array
    {
        return [
            'count' => $this->count(),
            'items' => $this->items,
        ];
    }
}
