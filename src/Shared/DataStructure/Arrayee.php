<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\HasDebugInfo;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits\ContainsAll;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits\ContainsAny;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits\CountProxy;
use Traversable;

/**
 * @template K of array-key
 * @template V
 * @template-implements Collection<K, V>
 */
class Arrayee implements Collection, HasDebugInfo, \JsonSerializable
{
    use CountProxy;
    use ContainsAll;
    use ContainsAny;

    /**
     * @param array<K, V> $items
     */
    public function __construct(
        protected array $items,
    ) {
        //
    }

    /**
     * @return array<K, V>
     */
    public function jsonSerialize(): array
    {
        return $this->items;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
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

    /**
     * @return Arrayee<K, V>
     */
    public function firsts(int $count): Arrayee
    {
        return new Arrayee(array_slice($this->items, 0, $count));
    }

    public function implode(string $sep): string
    {
        return implode($sep, $this->items);
    }

    /**
     * @template M
     * @param callable(V): M $mapper
     * @return array<M>
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

    /**
     * @param callable(V): bool $filter
     * @return Arrayee<K, V>
     */
    public function filter(callable $filter): Arrayee
    {
        return new Arrayee(array_filter($this->items, $filter));
    }

    public function __debugInfo(): array
    {
        return [
            'count' => $this->count(),
            'items' => $this->items,
        ];
    }
}
