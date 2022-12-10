<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Configuration\Config;

class ResolvedConfig
{
    public function __construct(
        public Config $config,
        public string $path,
    ) {
        //
    }
}
