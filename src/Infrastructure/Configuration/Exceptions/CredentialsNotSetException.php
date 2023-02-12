<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class CredentialsNotSetException extends MergeRequestLinterException
{
    public static function create(string $ciName): self
    {
        return new self(sprintf('Credentials for CI with "%s" not set', $ciName));
    }
}
