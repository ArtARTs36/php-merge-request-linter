<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;

class ResolvedConfig
{
    public function __construct(
        public Config $config,
        public string $path,
    ) {
        //
    }
}
