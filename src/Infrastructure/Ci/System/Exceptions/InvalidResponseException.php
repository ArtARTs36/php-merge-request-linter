<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class InvalidResponseException extends MergeRequestLinterException
{
    public static function make(string $reason, ?\Throwable $previous = null): self
    {
        return new self(
            sprintf('Given invalid response: %s', $reason),
            previous: $previous,
        );
    }
}
