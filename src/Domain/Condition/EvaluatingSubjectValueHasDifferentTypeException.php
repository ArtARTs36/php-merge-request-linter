<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

/**
 * Interface for EvaluatingSubjectValueHasDifferentTypeException.
 */
interface EvaluatingSubjectValueHasDifferentTypeException extends \Throwable
{
    /**
     * Get property name.
     */
    public function getPropertyName(): string;

    /**
     * Get real property type.
     */
    public function getRealPropertyType(): string;

    /**
     * Get expected property type.
     */
    public function getExpectedPropertyType(): string;
}
