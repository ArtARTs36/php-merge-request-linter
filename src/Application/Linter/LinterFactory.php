<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\CollectorRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;

class LinterFactory
{
    public function __construct(
        private readonly EventDispatcherInterface $events,
        private readonly CollectorRegistry        $metrics,
    ) {
    }

    public function create(Config $config): Linter
    {
        return new \ArtARTs36\MergeRequestLinter\Application\Linter\Linter(
            $config->rules,
            $config->linter->options,
            $this->events,
            $this->metrics,
        );
    }
}
