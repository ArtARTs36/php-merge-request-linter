<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Http\Client\ClientInterface;

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

    /**
     * @param array<string, array<mixed>|object> $config
     */
    public static function fromArray(
        #[ArrayShape([
            'rules' => 'array',
            'credentials' => 'array',
            'http_client' => 'object',
        ])]
        array $config
    ): self {
        if (isset($config['http_client'])) {
            if ($config['http_client'] instanceof ClientInterface) {
                $httpClientFactory = \Closure::fromCallable(function () use ($config) {
                    return $config['http_client'];
                });
            } elseif (is_callable($config['http_client'])) {
                $httpClientFactory = \Closure::fromCallable($config['http_client']);
            } else {
                throw new ConfigInvalidException('http_client');
            }
        } else {
            throw new ConfigInvalidException('http_client');
        }

        if (! isset($config['rules']) || ! is_iterable($config['rules'])) {
            throw ConfigInvalidException::fromKey('rules');
        }

        if (! isset($config['credentials']) || ! is_array($config['credentials'])) {
            throw ConfigInvalidException::fromKey('credentials');
        }

        return new self(
            Rules::make($config['rules']),
            new Map($config['credentials']),
            $httpClientFactory
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
