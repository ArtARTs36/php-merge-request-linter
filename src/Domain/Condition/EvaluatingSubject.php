<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;
use ArtARTs36\Str\Str;

/**
 * Interface for evaluating Subject.
 */
interface EvaluatingSubject
{
    /**
     * Extract numeric property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function numeric(): int|float;

    /**
     * Extract scalar property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function scalar(): int|string|float|bool;

    /**
     * Extract string property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function string(): Str;

    /**
     * Extract iterable property.
     * @return Arrayee<int|string, mixed>|ArrayMap<string, mixed>|Set<mixed>
     * @throws PropertyNotExists
     * @throws PropertyHasDifferentTypeException
     */
    public function collection(): Collection;

    /**
     * Extract property which implements $interface.
     * @template V
     * @param class-string<V> $interface
     * @return V
     */
    public function interface(string $interface): mixed;
}
