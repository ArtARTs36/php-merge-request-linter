<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class GivenInvalidPullRequestDataException extends MergeRequestLinterException
{
    public static function keyNotFound(string $key): self
    {
        return new self(sprintf('Key "%s" not found in response', $key));
    }

    public static function invalidType(string $key, string $expectedType, ?\Throwable $previous = null): self
    {
        return new self(
            sprintf('Value of key "%s" has invalid type. Expected type: %s', $key, $expectedType),
            previous: $previous,
        );
    }
}
