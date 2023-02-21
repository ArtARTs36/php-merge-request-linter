<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

/**
 * @template T as int|float
 */
class Number
{
    /**
     * @param T $number
     */
    public function __construct(
        private readonly int|float $number,
    ) {
        //
    }

    /**
     * @return T
     */
    public function value(): int|float
    {
        return $this->number;
    }

    /**
     * @param Number<T>|T $that
     */
    public function gte(self|int|float $that): bool
    {
        $thatValue = $that instanceof self ? $that->value() : $that;

        return $this->number >= $thatValue;
    }

    /**
     * @param Number<T>|T $that
     */
    public function lte(self|int|float $that): bool
    {
        $thatValue = $that instanceof self ? $that->value() : $that;

        return $this->number <= $thatValue;
    }
}
