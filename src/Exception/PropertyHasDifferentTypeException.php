<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class PropertyHasDifferentTypeException extends MergeRequestLinterException
{
    public static function make(string $property, string $realType, string $expectedType): self
    {
        return new self(sprintf('Property "%s" has different type "%s". Expected: %s', $property, $realType, $expectedType));
    }
}
