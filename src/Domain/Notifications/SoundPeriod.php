<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Notifications;

use ArtARTs36\MergeRequestLinter\Shared\Time\HourMinute;

class SoundPeriod
{
    public function __construct(
        public readonly HourMinute $from,
        public readonly HourMinute $to,
    ) {
        //
    }

    /**
     * @throws \Exception
     */
    public static function make(?string $value): self
    {
        if ($value === null || $value === '') {
            return new self(
                HourMinute::min(),
                HourMinute::max(),
            );
        }

        $parts = explode('-', $value);

        if (count($parts) !== 2) {
            throw new \Exception('Value must be follows mask "hh:mm - hh:mm"');
        }

        return new self(
            HourMinute::fromString($parts[0]),
            HourMinute::fromString($parts[1]),
        );
    }

    public function canAt(\DateTimeInterface $dateTime): bool
    {
        $hourMinute = HourMinute::fromDateTime($dateTime);

        return $this->from->gte($hourMinute) && $this->to->lte($hourMinute);
    }
}
