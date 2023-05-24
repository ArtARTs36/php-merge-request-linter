<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

final class Clock implements ClockInterface
{
    public function __construct(
        private readonly \DateTimeZone $tz,
    ) {
        //
    }

    public static function utc(): self
    {
        return self::on('UTC');
    }

    public static function on(string $timezone): self
    {
        return new self(new \DateTimeZone($timezone));
    }

    public function localize(DateTimeImmutable $dateTime): DateTimeImmutable
    {
        return $dateTime->setTimezone($this->tz);
    }

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
