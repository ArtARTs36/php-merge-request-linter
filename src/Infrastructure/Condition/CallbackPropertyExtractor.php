<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;
use ArtARTs36\Str\Facade\Str as StrFacade;
use ArtARTs36\Str\Str;

class CallbackPropertyExtractor implements PropertyExtractor
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
            $number = StrFacade::toNumber($val);

            return $number === null ? 0 : $number;
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
     */
    public function string(object $object, string $property): string
    {
        $val = $this->extract($object, $property);

        if (! is_string($val) && ! $val instanceof Str) {
            throw PropertyHasDifferentTypeException::make(
                $property,
                $this->getType($val),
                'string',
            );
        }

        return $val;
    }

    /**
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function collection(object $object, string $property): Collection
    {
        $val = $this->extract($object, $property);

        if (! is_array($val) && ! $val instanceof Set && ! $val instanceof ArrayMap) {
            throw PropertyHasDifferentTypeException::make(
                $property,
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
     * @throws PropertyNotExists
     */
    private function extract(object $object, string $property): mixed
    {
        $properties = explode('.', $property);
        $obj = $object;
        $val = null;

        foreach ($properties as $prop) {
            $val = $this->doExtract($obj, $prop);

            if (is_object($val)) {
                $obj = $val;
            }
        }

        return $val;
    }

    /**
     * @throws PropertyNotExists
     */
    private function doExtract(object $object, string $property): mixed
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
