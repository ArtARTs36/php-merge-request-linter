<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

/**
 * Interface for factory for EvaluatingSubject.
 */
interface EvaluatingSubjectFactory
{
    /**
     * Create subject for value.
     */
    public function createForValue(string $name, mixed $value): EvaluatingSubject;

    /**
     * Create subject for Property.
     */
    public function createForProperty(object $object, string $property): EvaluatingSubject;
}
