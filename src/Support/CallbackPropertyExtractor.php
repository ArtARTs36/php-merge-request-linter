<?php

namespace ArtARTs36\MergeRequestLinter\Support;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayableWrapper\WrapperFactory;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\Str\Facade\Str as StrFacade;
use ArtARTs36\Str\Str;

class CallbackPropertyExtractor implements PropertyExtractor
{
    public function __construct(
        private readonly WrapperFactory $arrayableFactory = new WrapperFactory(),
    ) {
        //
    }

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
    public function arrayable(object $object, string $property): Arrayable
    {
        $val = $this->extract($object, $property);

        if (! is_array($val) && ! $val instanceof Set && ! $val instanceof Map) {
            throw PropertyHasDifferentTypeException::make(
                $property,
                $this->getType($val),
                'array|Set|Map',
            );
        }

        return $this->arrayableFactory->create($val);
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
