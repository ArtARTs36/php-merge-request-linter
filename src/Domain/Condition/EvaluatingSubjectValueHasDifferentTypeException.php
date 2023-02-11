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
    public function getValueName(): string;

    /**
     * Get real property type.
     */
    public function getRealValueType(): string;

    /**
     * Get expected property type.
     */
    public function getExpectedValueType(): string;
}
