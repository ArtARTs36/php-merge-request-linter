<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\Collection;
use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

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
    public function string(): string;

    /**
     * Extract iterable property.
     * @return Arrayee<int|string, mixed>|ArrayMap<string, mixed>|Set<mixed>
     *@throws PropertyNotExists
     * @throws PropertyHasDifferentTypeException
     */
    public function collection(): Collection;
}
