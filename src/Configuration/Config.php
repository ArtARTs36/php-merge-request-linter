<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;

class Config
{
    public function __construct(protected Rules $rules, protected Map $credentials)
    {
        //
    }

    public static function fromArray(array $config): self
    {
        return new self(
            Rules::make($config['rules']),
            new Map($config['credentials']),
        );
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

    public function getCredentials(): Map
    {
        return $this->credentials;
    }
}
