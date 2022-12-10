<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;

class Config
{
    /**
     * @param Map<class-string<CiSystem>, RemoteCredentials> $credentials
     */
    public function __construct(
        protected Rules $rules,
        protected Map $credentials,
        protected \Closure $httpClientFactory,
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

    public function getHttpClientFactory(): \Closure
    {
        return $this->httpClientFactory;
    }
}
