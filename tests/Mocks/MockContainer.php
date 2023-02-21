<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Container\EntryNotFoundException;
use Psr\Container\ContainerInterface;

class MockContainer implements ContainerInterface
{
    public function __construct(
        private mixed $get = null,
        private bool $has = false,
    ) {
        //
    }

    public function get(string $id)
    {
        if ($this->get === null) {
            throw EntryNotFoundException::create($id);
        }

        return $this->get;
    }

    public function has(string $id): bool
    {
        return $this->has;
    }
}
