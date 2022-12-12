<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Support\Map;

interface PropertyExtractor
{
    /**
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function numeric(object $object, string $property): int|float;

    /**
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function scalar(object $object, string $property): int|string|float|bool;

    /**
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     * @return array<mixed>|Map<string, mixed>
     */
    public function iterable(object $object, string $property): array|Map;
}
