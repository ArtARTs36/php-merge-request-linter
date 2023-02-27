<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use Psr\EventDispatcher\EventDispatcherInterface;

class LinterFactory
{
    public function __construct(
        protected EventDispatcherInterface $events,
        private readonly MetricManager     $metrics,
    ) {
        //
    }

    public function create(Rules $rules): Linter
    {
        return new \ArtARTs36\MergeRequestLinter\Application\Linter\Linter(
            $rules,
            $this->events,
            $this->metrics,
        );
    }
}
