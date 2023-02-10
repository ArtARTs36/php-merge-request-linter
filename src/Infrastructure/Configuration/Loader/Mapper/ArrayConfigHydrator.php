<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\MapProxy;

class ArrayConfigHydrator
{
    public function __construct(
        private readonly CredentialMapper $credentialMapper,
        private readonly RulesMapper $rulesMapper,
    ) {
        //
    }

    /**
     * Hydrate raw array to Config object.
     * @param array<mixed> $data
     */
    public function hydrate(array $data): Config
    {
        if (! isset($data['rules']) || ! is_array($data['rules'])) {
            throw ConfigInvalidException::fromKey('rules');
        }

        $rules = $this->rulesMapper->map($data['rules']);

        $credentials = new MapProxy(function () use ($data) {
            return $this->credentialMapper->map($data['credentials']);
        });

        return new Config($rules, $credentials, new HttpClientConfig(
            $data['http_client']['type'] ?? HttpClientConfig::TYPE_DEFAULT,
            $data['http_client']['params'] ?? [],
        ));
    }
}
