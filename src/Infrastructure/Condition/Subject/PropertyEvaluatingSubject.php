<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ValueHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;

readonly class PropertyEvaluatingSubject implements EvaluatingSubject
{
    public function __construct(
        public object             $subject,
        private PropertyExtractor $propertyExtractor,
        private string            $property,
    ) {
        //
    }

    /**
     * Extract scalar property.
     * @throws PropertyHasDifferentTypeException
     * @throws PropertyNotExists
     */
    public function scalar(): int|string|float|bool
    {
        try {
            return $this->propertyExtractor->scalar($this->subject, $this->property);
        } catch (ValueHasDifferentTypeException $e) {
            throw $this->createPropertyHasDifferentTypeException($e, $this->property);
        }
    }

    public function interface(string $interface): mixed
    {
        try {
            return $this->propertyExtractor->interface($this->subject, $this->property, $interface);
        } catch (ValueHasDifferentTypeException $e) {
            throw $this->createPropertyHasDifferentTypeException($e, $this->property);
        }
    }

    public function name(): string
    {
        return $this->property;
    }

    private function createPropertyHasDifferentTypeException(ValueHasDifferentTypeException $e, string $property): PropertyHasDifferentTypeException
    {
        return PropertyHasDifferentTypeException::make($property, $e->getRealPropertyType(), $e->getExpectedPropertyType());
    }
}
