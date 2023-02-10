<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\RemoteCredentials;

final class Token implements RemoteCredentials
{
    public function __construct(protected string $token)
    {
        //
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
