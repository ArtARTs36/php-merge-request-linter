<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ValueHasDifferentTypeException;
use ArtARTs36\Str\Facade\Str as StrFacade;
use ArtARTs36\Str\Str;

class TypeCaster
{
    /**
     * @throws PropertyHasDifferentTypeException
     */
    public function numeric(mixed $val): int|float
    {
        if (! is_numeric($val)) {
            throw ValueHasDifferentTypeException::make($this->getType($val), 'int|float');
        }

        if (is_string($val)) {
            $number = StrFacade::toNumber($val);

            return $number === null ? 0 : $number;
        }

        return is_float($val) ? $val : (int) $val;
    }

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
     * @throws PropertyHasDifferentTypeException
     */
    public function string(mixed $val): Str
    {
        if (is_string($val)) {
            return Str::make($val);
        } elseif ($val instanceof Str) {
            return $val;
        }

        throw ValueHasDifferentTypeException::make(
            $this->getType($val),
            'string|Str',
        );
    }

    /**
     * @throws PropertyHasDifferentTypeException
     */
    public function collection(mixed $val): Collection
    {
        if (! is_array($val) && ! $val instanceof Set && ! $val instanceof ArrayMap) {
            throw ValueHasDifferentTypeException::make(
                $this->getType($val),
                'array|Set|Map',
            );
        }

        if (is_array($val)) {
            return new Arrayee($val);
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
