<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Exception\ConfigNotFound;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;
use Psr\Http\Client\ClientInterface;

class PhpConfigLoader implements ConfigLoader
{
    public function __construct(
        private FileSystem $files,
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
        if (isset($config['http_client'])) {
            if ($config['http_client'] instanceof ClientInterface) {
                $httpClientFactory = \Closure::fromCallable(function () use ($config) {
                    return $config['http_client'];
                });
            } elseif (is_callable($config['http_client'])) {
                $httpClientFactory = \Closure::fromCallable($config['http_client']);
            } else {
                throw ConfigInvalidException::fromKey('http_client');
            }
        } else {
            throw ConfigInvalidException::fromKey('http_client');
        }

        if (! isset($config['rules']) || ! is_iterable($config['rules'])) {
            throw ConfigInvalidException::fromKey('rules');
        }

        if (! isset($config['credentials']) || ! is_array($config['credentials'])) {
            throw ConfigInvalidException::fromKey('credentials');
        }

        return new Config(
            Rules::make($config['rules']),
            new Map($config['credentials']),
            $httpClientFactory,
        );
    }
}
