<?php

namespace ArtARTs36\MergeRequestLinter\Credentials;

use Gitlab\Client;

class GitlabCredentials
{
    protected function __construct(
        public string $token,
        public string $method,
    ) {
        //
    }

    public static function fromHttpToken(string $token): self
    {
        return new self($token, Client::AUTH_HTTP_TOKEN);
    }

    public static function fromOAuthToken(string $token): self
    {
        return new self($token, Client::AUTH_OAUTH_TOKEN);
    }
}
