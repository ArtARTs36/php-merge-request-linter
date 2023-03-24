<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableInvalidException;
use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

final class VarHasDifferentTypeException extends MergeRequestLinterException implements EnvironmentVariableInvalidException
{
    public static function make(string $var, string $expectedType, string $realType): self
    {
        return new self(
            sprintf(
                'Environment variable "%s" has type: "%s", expected type "%s"',
                $var,
                $realType,
                $expectedType,
            ),
        );
    }
}
