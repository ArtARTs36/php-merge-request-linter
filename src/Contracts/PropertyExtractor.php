<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\MergeRequestLinter\Support\Set;

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
     * Extract iterable property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     * @return array<mixed>|Set<string, bool>|Map<string, mixed>
     */
    public function iterable(object $object, string $property): array|Set|Map;
}
