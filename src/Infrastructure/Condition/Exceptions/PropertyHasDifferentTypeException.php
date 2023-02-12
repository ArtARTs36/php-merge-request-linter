<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectException;

class PropertyHasDifferentTypeException extends MergeRequestLinterException implements EvaluatingSubjectException
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

    public function getValueName(): string
    {
        return $this->propertyName;
    }

    public function getRealValueType(): string
    {
        return $this->realPropertyType;
    }

    public function getExpectedValueType(): string
    {
        return $this->expectedPropertyType;
    }
}
