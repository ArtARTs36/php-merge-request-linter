<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\Str\Str;
use ArtARTs36\Str\Facade\Str as StrFacade;

class PropertyExtractor
{
    /**
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function numeric(object $object, string $property): int|float
    {
        $val = $this->extract($object, $property);

        if (! is_numeric($val)) {
            throw PropertyHasDifferentTypeException::make($property, $this->getType($val), 'int|float');
        }

        if (is_string($val)) {
            return StrFacade::contains($val, '.') ? (float) $val : (int) $val;
        }

        return is_float($val) ? $val : (int) $val;
    }

    /**
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function scalar(object $object, string $property): int|string|float|bool
    {
        $val = $this->extract($object, $property);

        if (! is_scalar($val) && ! $val instanceof Str) {
            throw PropertyHasDifferentTypeException::make(
                $property,
                $this->getType($val),
                'int|float|string|bool',
            );
        }

        return $val;
    }

    /**
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     * @return array<mixed>|Map<string, mixed>
     */
    public function iterable(object $object, string $property): array|Map
    {
        $val = $this->extract($object, $property);

        if (! is_array($val) && ! $val instanceof Map) {
            throw PropertyHasDifferentTypeException::make(
                $property,
                $this->getType($val),
                'array|Map',
            );
        }

        return $val;
    }

    /**
     * @throws PropertyNotExists
     */
    private function extract(object $object, string $property): mixed
    {
        if (! property_exists($object, $property)) {
            throw PropertyNotExists::make($property);
        }

        $extractor = function () use ($property) {
            return $this->$property;
        };

        return $extractor->call($object);
    }

    private function getType(mixed $value): string
    {
        if (is_object($value)) {
            return get_class($value);
        }

        return gettype($value);
    }
}
