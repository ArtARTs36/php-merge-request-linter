<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

interface AuthenticatorMapper
{
    public function map(array|string $credentials): Authenticator;
}
