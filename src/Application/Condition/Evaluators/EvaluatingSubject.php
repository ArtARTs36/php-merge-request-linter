<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;

class EvaluatingSubject implements \ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject
{
    public function __construct(
        public readonly object $subject,
        private readonly PropertyExtractor $propertyExtractor,
        private readonly string $property,
    ) {
        //
    }

    /**
     * Extract numeric property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function numeric(): int|float
    {
        return $this->propertyExtractor->numeric($this->subject, $this->property);
    }

    /**
     * Extract scalar property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function scalar(): int|string|float|bool
    {
        return $this->propertyExtractor->scalar($this->subject, $this->property);
    }

    /**
     * Extract string property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function string(): string
    {
        return $this->propertyExtractor->string($this->subject, $this->property);
    }

    /**
     * Extract iterable property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function collection(): Collection
    {
        return $this->propertyExtractor->collection($this->subject, $this->property);
    }
}
