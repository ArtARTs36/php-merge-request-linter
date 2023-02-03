<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

use Psr\Http\Client\ClientExceptionInterface;

class InvalidCredentialsException extends MergeRequestLinterException implements ClientExceptionInterface
{
    public static function fromCiName(string $ciName): self
    {
        return new self("Given invalid credentials for $ciName");
    }

    public static function fromResponse(string $host, string $response): self
    {
        return new self("Given invalid credentials for $host. Server returns: ". $response);
    }
}
