<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number;

class HourMinute
{
    private function __construct(
        public readonly Number $hour,
        public readonly Number $minute,
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
            throw new \Exception('Hour must be >= 0 and <= 23');
        }

        if ($minute < 0 || $minute > 59) {
            throw new \Exception('Hour must be >= 0 and <= 59');
        }

        return new self(new Number($hour), new Number($minute));
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

        return self::make($parts[0], $parts[1]);
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): self
    {
        return self::make(
            (int) $dateTime->format('H'),
            (int) $dateTime->format('i'),
        );
    }

    public function gte(self $that): bool
    {
        if ($this->hour->lt($that->hour)) {
            return false;
        }

        return $this->minute->gte($that->minute);
    }

    public function lte(self $that): bool
    {
        if ($this->hour->gt($that->hour)) {
            return false;
        }

        return $this->minute->lte($that->minute);
    }
}
