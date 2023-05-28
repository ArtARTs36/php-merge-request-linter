<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

use Traversable;

/**
 * Interface for Collections.
 * @template K of array-key
 * @template V
 * @template-implements Map<K, V>
 */
class MapProxy implements Map
{
    /** @var Map<K, V>|null */
    private ?Map $map = null;

    /**
     * @param \Closure(): Map<K, V> $mapFetcher
     * @param int<0, max>|null $count
     */
    public function __construct(
        private readonly \Closure $mapFetcher,
        private readonly ?int $count = null,
    ) {
        //
    }

    /**
     * @return Map<K, V>
     */
    private function retrieveMap(): Map
    {
        if ($this->map === null) {
            $this->map = ($this->mapFetcher)();
        }

        return $this->map;
    }

    public function count(): int
    {
        return $this->count ?? $this->retrieveMap()->count();
    }

    public function containsAny(iterable $values): bool
    {
        return $this->retrieveMap()->containsAny($values);
    }

    public function has(string $id): bool
    {
        return $this->retrieveMap()->has($id);
    }

    public function contains(mixed $value): bool
    {
        return $this->retrieveMap()->contains($value);
    }

    public function containsAll(iterable $values): bool
    {
        return $this->retrieveMap()->containsAll($values);
    }

    public function getIterator(): Traversable
    {
        return $this->retrieveMap()->getIterator();
    }

    public function get(string $id)
    {
        return $this->retrieveMap()->get($id);
    }

    public function isEmpty(): bool
    {
        return $this->retrieveMap()->isEmpty();
    }

    public function keys(): Arrayee
    {
        return $this->retrieveMap()->keys();
    }

    public function toArray(): array
    {
        return $this->retrieveMap()->toArray();
    }

    public function __debugInfo(): array
    {
        if ($this->map === null) {
            return [
                'count' => null,
                'items' => 'Not loaded',
            ];
        }

        return $this->map->__debugInfo();
    }
}
