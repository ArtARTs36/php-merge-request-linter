<?php

namespace ArtARTs36\MergeRequestLinter\Support;

use _PHPStan_d279f388f\Psr\Container\NotFoundExceptionInterface;
use ArtARTs36\MergeRequestLinter\Exception\MergeRequestLinterException;
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
            throw new class () extends MergeRequestLinterException implements NotFoundExceptionInterface {};
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
