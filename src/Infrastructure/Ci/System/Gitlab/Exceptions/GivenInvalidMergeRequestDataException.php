<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Exceptions;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class GivenInvalidMergeRequestDataException extends MergeRequestLinterException
{
    public static function keyNotFound(string $key): self
    {
        return new self(sprintf('Key "%s" not found in response', $key));
    }

    public static function invalidType(string $key, string $expectedType): self
    {
        return new self(sprintf('Value of key "%s" has invalid type. Expected type: %s', $key, $expectedType));
    }
}
