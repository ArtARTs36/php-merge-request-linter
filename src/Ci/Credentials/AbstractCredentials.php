<?php

namespace ArtARTs36\MergeRequestLinter\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;

abstract class AbstractCredentials implements RemoteCredentials
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
