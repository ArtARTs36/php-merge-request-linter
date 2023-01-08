<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;

abstract class AbstractArrayConfigLoader implements ConfigLoader
{
    /**
     * @return array<mixed>
     */
    abstract protected function loadConfigArray(string $path): array;

    public function __construct(
        private CredentialMapper $credentialMapper,
        private RulesMapper $rulesMapper,
    ) {
        //
    }

    public function load(string $path): Config
    {
        $data = $this->loadConfigArray($path);

        if (! isset($data['rules']) || ! is_array($data['rules'])) {
            throw ConfigInvalidException::fromKey('rules');
        }

        $rules = $this->rulesMapper->map($data['rules']);

        if (! class_exists('\GuzzleHttp\Client')) {
            throw new ConfigInvalidException('HTTP Client unavailable');
        }

        $credentials = $this->credentialMapper->map($data['credentials']);

        if ($credentials->isEmpty()) {
            throw new ConfigInvalidException('Credentials must be filled');
        }

        return new Config($rules, $credentials, new HttpClientConfig(
            $data['http_client']['type'] ?? HttpClientConfig::TYPE_DEFAULT,
            $data['http_client']['params'] ?? [],
        ));
    }
}
