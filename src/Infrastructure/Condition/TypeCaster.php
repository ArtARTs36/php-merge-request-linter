<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ValueHasDifferentTypeException;
use ArtARTs36\Str\Str;

class TypeCaster
{
    /**
     * @throws PropertyHasDifferentTypeException
     */
    public function scalar(mixed $val): int|string|float|bool
    {
        if (! is_scalar($val) && ! $val instanceof Str) {
            throw ValueHasDifferentTypeException::make(
                $this->getType($val),
                'int|float|string|bool',
            );
        }

        return $val;
    }

    /**
     * Extract value which implements $interface.
     * @template V
     * @param class-string<V> $interface
     * @return V
     */
    public function interface(string $interface, mixed $val): mixed
    {
        if (is_array($val)) {
            $val = new Arrayee($val);
        } elseif (is_string($val)) {
            $val = Str::make($val);
        } elseif (is_int($val) || is_float($val)) {
            $val = new Number($val);
        }

        if ($val instanceof $interface) {
            return $val;
        }

        throw ValueHasDifferentTypeException::make(
            $this->getType($val),
            $interface,
        );
    }

    private function getType(mixed $value): string
    {
        if (is_object($value)) {
            return get_class($value);
        }

        return gettype($value);
    }
}
