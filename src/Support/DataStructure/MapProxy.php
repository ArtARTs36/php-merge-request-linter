<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
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
     */
    public function __construct(
        private \Closure $mapFetcher,
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
        return $this->retrieveMap()->count();
    }

    public function containsAny(iterable $values): bool
    {
        return $this->retrieveMap()->containsAny($values);
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
}
