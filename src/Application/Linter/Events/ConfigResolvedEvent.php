<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter\Events;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ResolvedConfig;

/**
 * @codeCoverageIgnore
 */
readonly class ConfigResolvedEvent
{
    public function __construct(
        public ResolvedConfig $config,
    ) {
    }
}
