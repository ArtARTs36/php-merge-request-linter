<?php

namespace ArtARTs36\MergeRequestLinter\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use Gitlab\Client;

class GitlabCredentials implements RemoteCredentials
{
    protected function __construct(
        protected string $token,
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

    public function getToken(): string
    {
        return $this->token;
    }
}
