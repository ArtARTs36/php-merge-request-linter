<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Container;

use Psr\Container\ContainerInterface;

/**
 * @phpstan-type Binder = callable(MapContainer): object
 */
class MapContainer implements ContainerInterface
{
    /** @var array<class-string, Binder> */
    private array $binds;

    /**
     * @param array<class-string, object> $map
     */
    public function __construct(
        private array $map = [],
    ) {
        //
    }

    /**
     * @template T as object
     * @param class-string<T> $id
     * @return T
     */
    public function get(string $id)
    {
        if (isset($this->map[$id])) {
            // @phpstan-ignore-next-line
            return $this->map[$id];
        }

        $binder = $this->binds[$id] ?? null;

        if ($binder === null) {
            throw EntryNotFoundException::create($id);
        }

        $obj = $binder($this);

        $this->set($id, $obj);

        return $obj;
    }

    /**
     * @param class-string $id
     */
    public function has(string $id): bool
    {
        return isset($this->map[$id]) || isset($this->binds[$id]);
    }

    /**
     * @template V as object
     * @param class-string<V> $id
     * @param V $object
     */
    public function set(string $id, mixed $object): void
    {
        $this->map[$id] = $object;
    }

    /**
     * @param class-string $id
     * @param Binder $callback
     */
    public function bind(string $id, callable $callback): void
    {
        $this->binds[$id] = $callback;
    }
}
