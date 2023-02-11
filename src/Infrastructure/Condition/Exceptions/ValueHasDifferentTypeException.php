<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;

class ValueHasDifferentTypeException extends MergeRequestLinterException
{
    public function __construct(
        private readonly string $realPropertyType,
        private readonly string $expectedPropertyType,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function make(string $realType, string $expectedType): self
    {
        return new self(
            $realType,
            $expectedType,
            sprintf('Value has different type "%s". Expected: %s', $realType, $expectedType),
        );
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
