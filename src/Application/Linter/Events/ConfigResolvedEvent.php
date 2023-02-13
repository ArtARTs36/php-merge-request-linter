<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter\Events;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ResolvedConfig;

class ConfigResolvedEvent
{
    public function __construct(
        public readonly ResolvedConfig $config,
    ) {
        //
    }
}