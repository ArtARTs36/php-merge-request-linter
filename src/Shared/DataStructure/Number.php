<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

class Number
{
    public function __construct(
        private readonly int|float $number,
    ) {
        //
    }

    public function value(): int|float
    {
        return $this->number;
    }

    public function gte(self|int|float $that): bool
    {
        $thatValue = $that instanceof self ? $that->value() : $that;

        return $this->number >= $thatValue;
    }

    public function lte(self|int|float $that): bool
    {
        $thatValue = $that instanceof self ? $that->value() : $that;

        return $this->number <= $thatValue;
    }
}
