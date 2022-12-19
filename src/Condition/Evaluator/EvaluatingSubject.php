<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;

class EvaluatingSubject implements \ArtARTs36\MergeRequestLinter\Contracts\EvaluatingSubject
{
    public function __construct(
        public readonly object $subject,
        private readonly PropertyExtractor $propertyExtractor,
        public readonly string $property,
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
    public function arrayable(): Arrayable
    {
        return $this->propertyExtractor->arrayable($this->subject, $this->property);
    }

    public function propertyName(): string
    {
        return $this->property;
    }
}