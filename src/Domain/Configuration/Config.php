<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\RemoteCredentials;

class Config
{
    /**
     * @param Map<class-string<CiSystem>, RemoteCredentials> $credentials
     */
    public function __construct(
        protected Rules            $rules,
        protected Map         $credentials,
        protected HttpClientConfig $httpClient,
    ) {
        //
    }

    public function getRules(): Rules
    {
        return $this->rules;
    }

    /**
     * @return Map<class-string<CiSystem>, RemoteCredentials>
     */
    public function getCredentials(): Map
    {
        return $this->credentials;
    }

    public function getHttpClient(): HttpClientConfig
    {
        return $this->httpClient;
    }
}
