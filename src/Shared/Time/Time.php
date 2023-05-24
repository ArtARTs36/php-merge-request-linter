<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

class Time
{
    private function __construct(
        public readonly int $hour,
        public readonly int $minute,
    ) {
        //
    }

    public static function min(): self
    {
        return self::make(0, 0);
    }

    public static function max(): self
    {
        return self::make(23, 59);
    }

    /**
     * @throws \Exception
     */
    public static function make(int $hour, int $minute): self
    {
        if ($hour < 0 || $hour > 23) {
            throw new InvalidTimeValueException(sprintf(
                'Hour must be >= 0 and <= 23. Given: %d',
                $hour,
            ));
        }

        if ($minute < 0 || $minute > 59) {
            throw new InvalidTimeValueException(sprintf(
                'Minute must be >= 0 and <= 59. Given: %d',
                $minute,
            ));
        }

        return new self($hour, $minute);
    }

    /**
     * @throws \Exception
     */
    public static function fromString(string $value): self
    {
        $parts = explode(':', $value);

        if (count($parts) !== 2) {
            throw new \Exception('Value must be follows mask "hh:mm"');
        }

        if (! is_numeric($parts[0])) {
            throw new \Exception('Value must be follows mask "hh:mm"');
        }

        $hour = (int) $parts[0];

        if (! is_numeric($parts[1])) {
            throw new \Exception('Value must be follows mask "hh:mm"');
        }

        $minute = (int) $parts[1];

        return self::make($hour, $minute);
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): self
    {
        return self::make(
            (int) $dateTime->format('H'),
            (int) $dateTime->format('i'),
        );
    }

    public function lte(self $that): bool
    {
        return $this->hour < $that->hour || ($this->hour === $that->hour && $this->minute <= $that->minute);
    }

    public function gte(self $that): bool
    {
        return $this->hour > $that->hour || ($this->hour === $that->hour && $this->minute >= $that->minute);
    }
}
