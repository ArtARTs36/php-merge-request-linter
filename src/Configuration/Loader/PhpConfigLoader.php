<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;

class PhpConfigLoader implements ConfigLoader
{
    public function load(string $path): Config
    {
        try {
            $config = require $path;
        } catch (\Throwable $e) {
            throw new ConfigInvalidException(previous: $e);
        }

        if (is_array($config)) {
            return Config::fromArray($config);
        }

        if ($config instanceof Config) {
            return $config;
        }

        throw new ConfigInvalidException();
    }
}
