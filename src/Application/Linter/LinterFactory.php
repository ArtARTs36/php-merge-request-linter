<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use Psr\EventDispatcher\EventDispatcherInterface;

class LinterFactory
{
    public function __construct(
        protected EventDispatcherInterface $events,
        private readonly MetricManager     $metrics,
    ) {
    }

    public function create(Config $config): Linter
    {
        return new \ArtARTs36\MergeRequestLinter\Application\Linter\Linter(
            $config->getRules(),
            $config->getLinter()->options,
            $this->events,
            $this->metrics,
        );
    }
}
