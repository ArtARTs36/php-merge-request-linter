<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

class ConfigLoader
{
    public function load(string $path): Config
    {
        $config = require $path;

        if (is_array($config)) {
            return Config::fromArray($config);
        }

        if ($config instanceof Config) {
            return $config;
        }

        throw new \RuntimeException();
    }
}
