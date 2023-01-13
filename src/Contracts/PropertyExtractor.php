<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

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
     * @return Arrayee<int|string, mixed>|ArrayMap<string, mixed>|Set<mixed>
     *@throws PropertyNotExists
     * @throws PropertyHasDifferentTypeException
     */
    public function collection(object $object, string $property): Collection;
}
