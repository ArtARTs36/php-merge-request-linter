<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Container;

use Psr\Container\ContainerInterface;

class MapContainer implements ContainerInterface
{
    /**
     * @param array<class-string, object> $map
     */
    public function __construct(
        private array $map = [],
    ) {
        //
    }

    /**
     * @param class-string $id
     */
    public function get(string $id)
    {
        if (! $this->has($id)) {
            throw EntryNotFoundException::create($id);
        }

        return $this->map[$id];
    }

    /**
     * @param class-string $id
     */
    public function has(string $id): bool
    {
        return isset($this->map[$id]);
    }

    /**
     * @param class-string $id
     */
    public function set(string $id, object $object): void
    {
        $this->map[$id] = $object;
    }
}
