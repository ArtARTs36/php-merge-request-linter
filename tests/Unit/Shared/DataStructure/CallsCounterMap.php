<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

class CallsCounterMap implements Map
{
    public function __construct(
        public int $counter = 0,
    ) {
        //
    }

    public function containsAny(iterable $values): bool
    {
        ++$this->counter;

        return true;
    }

    public function contains(mixed $value): bool
    {
        ++$this->counter;

        return true;
    }

    public function containsAll(iterable $values): bool
    {
        ++$this->counter;

        return true;
    }

    public function isEmpty(): bool
    {
        ++$this->counter;

        return false;
    }

    public function getIterator(): \Traversable
    {
        ++$this->counter;

        return new \ArrayIterator([]);
    }

    public function count(): int
    {
        ++$this->counter;

        return 500;
    }

    public function __debugInfo(): array
    {
        ++$this->counter;

        return ['null'];
    }

    public function get(string $id)
    {
        ++$this->counter;

        return 1;
    }

    public function keys(): Arrayee
    {
        ++$this->counter;

        return new Arrayee([0]);
    }
}
