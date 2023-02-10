<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;
use Psr\Http\Client\ClientExceptionInterface;

final class ServerUnexpectedResponseException extends MergeRequestLinterException implements ClientExceptionInterface
{
    public static function create(string $host, int $status, string $response): self
    {
        return new self($host . ' returns response with code ' . $status . '. Response: ' . $response);
    }
}
