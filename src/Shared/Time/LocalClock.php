<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

use DateTimeImmutable;

final readonly class LocalClock implements Clock
{
    public function __construct(
        private \DateTimeZone $tz,
    ) {
    }

    /**
     * @throws \Exception
     */
    public static function utc(): self
    {
        return self::on('UTC');
    }

    /**
     * @throws \Exception
     */
    public static function on(string $timezone): self
    {
        try {
            return new self(new \DateTimeZone($timezone));
        } catch (\Throwable) {
            throw new \Exception(sprintf(
                'TimeZone "%s" invalid. Available values: [%s]',
                $timezone,
                implode(', ', \DateTimeZone::listIdentifiers()),
            ));
        }
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
