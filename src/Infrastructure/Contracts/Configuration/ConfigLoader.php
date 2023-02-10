<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigException;

/**
 * Config Loader.
 */
interface ConfigLoader
{
    /**
     * Load config from path.
     * @throws ConfigException
     */
    public function load(string $path): Config;
}
