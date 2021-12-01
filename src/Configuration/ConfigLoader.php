<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;

class ConfigLoader
{
    /**
     * @throws ConfigInvalidException
     */
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
