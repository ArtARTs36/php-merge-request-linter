<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

final class MockClock implements ClockInterface
{
    public function __construct(
        private readonly string $time,
    ) {
        //
    }

    public function now(): DateTimeImmutable
    {
        return new \DateTimeImmutable($this->time);
    }
}
