<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;
use Psr\Http\Client\ClientExceptionInterface;

final class InvalidCredentialsException extends MergeRequestLinterException implements ClientExceptionInterface
{
    public static function fromResponse(string $host, string $response): self
    {
        return new self("Given invalid credentials for $host. Server returns: ". $response);
    }
}
