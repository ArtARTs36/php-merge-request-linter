<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer;

/**
 * @codeCoverageIgnore
 */
abstract class Provider implements ServiceProvider
{
    public function __construct(
        protected readonly MapContainer $container,
    ) {
    }
}
