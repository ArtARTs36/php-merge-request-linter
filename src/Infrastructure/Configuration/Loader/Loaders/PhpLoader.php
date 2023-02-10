<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\Rules;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

/**
 * @deprecated
 */
class PhpLoader implements ConfigLoader
{
    public function __construct(
        private readonly FileSystem $files,
    ) {
        //
    }

    public function load(string $path): Config
    {
        if (! $this->files->exists($path)) {
            throw ConfigNotFound::fromPath($path);
        }

        try {
            $config = require $path;
        } catch (\Throwable $e) {
            throw new ConfigInvalidException(previous: $e);
        }

        if (is_array($config)) {
            return $this->createFromArray($config);
        }

        if ($config instanceof Config) {
            return $config;
        }

        throw new ConfigInvalidException('PHP Config must be php array or ArtARTs36\MergeRequestLinter\Configuration\Config instance');
    }

    /**
     * @param array<mixed> $config
     */
    protected function createFromArray(array $config): Config
    {
        if (! isset($config['rules']) || ! is_iterable($config['rules'])) {
            throw ConfigInvalidException::fromKey('rules');
        }

        if (empty($config['credentials']) || ! is_array($config['credentials'])) {
            throw new ConfigInvalidException('Credentials must be filled');
        }

        return new Config(
            Rules::make($config['rules']),
            new ArrayMap($config['credentials']),
            $this->makeHttpClientConfig($config),
        );
    }

    /**
     * @param array<mixed> $data
     */
    private function makeHttpClientConfig(array $data): HttpClientConfig
    {
        return new HttpClientConfig(
            isset($data['http_client']['type']) ? $data['http_client']['type'] : HttpClientConfig::TYPE_DEFAULT,
            isset($data['http_client']['params']) ? $data['http_client']['params'] : [],
        );
    }
}
