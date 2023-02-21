<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

final class QueueClock implements ClockInterface
{
    public function __construct(
        private array $queue,
    ) {
        //
    }

    public function now(): DateTimeImmutable
    {
        return array_shift($this->queue);
    }
}
