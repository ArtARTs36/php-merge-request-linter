<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectValueHasDifferentTypeException;

class PropertyHasDifferentTypeException extends MergeRequestLinterException implements EvaluatingSubjectValueHasDifferentTypeException
{
    public function __construct(
        private readonly string $propertyName,
        private readonly string $realPropertyType,
        private readonly string $expectedPropertyType,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function make(string $property, string $realType, string $expectedType): self
    {
        return new self(
            $property,
            $realType,
            $expectedType,
            sprintf('Property "%s" has different type "%s". Expected: %s', $property, $realType, $expectedType),
        );
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function getRealPropertyType(): string
    {
        return $this->realPropertyType;
    }

    public function getExpectedPropertyType(): string
    {
        return $this->expectedPropertyType;
    }
}
