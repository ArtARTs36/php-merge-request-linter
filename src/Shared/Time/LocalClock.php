<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

use DateTimeImmutable;

final class LocalClock implements Clock
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

    public function create(string $datetime): DateTimeImmutable
    {
        return $this->localize(new DateTimeImmutable($datetime));
    }

    public function localize(DateTimeImmutable $dateTime): DateTimeImmutable
    {
        return $dateTime->setTimezone($this->tz);
    }

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->tz);
    }
}
