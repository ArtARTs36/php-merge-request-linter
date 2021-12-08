<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

final class ServerUnexpectedResponseException extends MergeRequestLinterException
{
    public static function create(string $ciName, int $status, string $response): self
    {
        return new self($ciName . ' returns response with code ' . $status . '. Response: ' . $response);
    }
}
