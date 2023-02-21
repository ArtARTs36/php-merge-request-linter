<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

final class Clock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
