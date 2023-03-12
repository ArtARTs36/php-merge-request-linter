<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

/**
 * Interface for authenticator mappers
 */
interface AuthenticatorMapper
{
    /**
     * Map raw data to Authenticator.
     * @param array<string, mixed> $credentials
     */
    public function map(array|string $credentials): Authenticator;
}
