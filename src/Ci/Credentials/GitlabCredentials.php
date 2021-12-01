<?php

namespace ArtARTs36\MergeRequestLinter\Ci\Credentials;

use Gitlab\Client;

class GitlabCredentials extends AbstractCredentials
{
    protected function __construct(
        protected string $token,
        public string $method,
    ) {
        parent::__construct($this->token);
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
