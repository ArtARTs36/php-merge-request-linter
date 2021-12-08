<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class InvalidCredentialsException extends \RuntimeException
{
    public static function fromCiName(string $ciName): self
    {
        return new self("Given invalid credentials for $ciName");
    }

    public static function fromResponse(string $ciName, string $response): self
    {
        return new self("Given invalid credentials for $ciName. Server returns: ". $response);
    }
}
