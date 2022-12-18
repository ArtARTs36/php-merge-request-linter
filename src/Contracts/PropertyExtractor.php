<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;

/**
 * Property Extractor.
 */
interface PropertyExtractor
{
    /**
     * Extract numeric property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function numeric(object $object, string $property): int|float;

    /**
     * Extract scalar property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function scalar(object $object, string $property): int|string|float|bool;

    /**
     * Extract string property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function string(object $object, string $property): string;

    /**
     * Extract iterable property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function iterable(object $object, string $property): Arrayable;
}
