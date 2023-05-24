<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

use Psr\Clock\ClockInterface;

/**
 * Interface for clocks.
 */
interface Clock extends ClockInterface
{
    /**
     * Localize date time.
     */
    public function localize(\DateTimeImmutable $dateTime): \DateTimeImmutable;
}
