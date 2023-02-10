<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;
use Psr\Http\Client\ClientExceptionInterface;

final class ServerUnexpectedResponseException extends MergeRequestLinterException implements ClientExceptionInterface
{
    public static function create(string $ciName, int $status, string $response): self
    {
        return new self($ciName . ' returns response with code ' . $status . '. Response: ' . $response);
    }
}
