<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Exception\ConfigException;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Exception\ConfigNotFound;

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
