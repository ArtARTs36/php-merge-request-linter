<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;

/**
 * Config Loader.
 */
interface ConfigLoader
{
    /**
     * Load config from path.
     * @throws ConfigInvalidException
     */
    public function load(string $path): Config;
}
