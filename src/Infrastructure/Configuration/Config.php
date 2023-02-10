<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\Rules;
use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\RemoteCredentials;

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

    public function addRule(Rule ...$rules): self
    {
        foreach ($rules as $rule) {
            $this->rules->add($rule);
        }

        return $this;
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
