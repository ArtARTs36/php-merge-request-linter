<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

class TimePeriod
{
    public function __construct(
        public readonly Time $from,
        public readonly Time $to,
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
                Time::min(),
                Time::max(),
            );
        }

        $parts = explode('-', $value);

        if (count($parts) !== 2) {
            throw new \Exception('Value must be follows mask "hh:mm - hh:mm"');
        }

        return new self(
            Time::fromString($parts[0]),
            Time::fromString($parts[1]),
        );
    }

    public function input(\DateTimeInterface $dateTime): bool
    {
        $time = Time::fromDateTime($dateTime);

        return $this->from->gte($time) && $this->to->lte($time);
    }
}
