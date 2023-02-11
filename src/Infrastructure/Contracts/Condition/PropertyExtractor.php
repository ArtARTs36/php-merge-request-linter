<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectValueHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;
use ArtARTs36\Str\Str;

/**
 * Property Extractor.
 */
interface PropertyExtractor
{
    /**
     * Extract numeric property.
     * @throws EvaluatingSubjectValueHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function numeric(object $object, string $property): int|float;

    /**
     * Extract scalar property.
     * @throws EvaluatingSubjectValueHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function scalar(object $object, string $property): int|string|float|bool;

    /**
     * Extract string property.
     * @throws EvaluatingSubjectValueHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function string(object $object, string $property): Str;

    /**
     * Extract iterable property.
     * @return Arrayee<int|string, mixed>|ArrayMap<string, mixed>|Set<mixed>
     * @throws PropertyNotExists
     * @throws EvaluatingSubjectValueHasDifferentTypeException
     */
    public function collection(object $object, string $property): Collection;

    /**
     * Extract property which implements $interface.
     * @template V
     * @param class-string<V> $interface
     * @return V
     */
    public function interface(object $object, string $property, string $interface): mixed;
}
