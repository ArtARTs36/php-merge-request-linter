<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Config;

use ArtARTs36\MergeRequestLinter\Exception\ConfigException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;

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
