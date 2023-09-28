<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Metrics;

use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasFailedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasSuccessfulEvent;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricRegisterer;

class RuleLintStateMetricHandler
{
    public function __construct(
        private readonly CounterVector $counter,
    ) {
    }

    public static function make(MetricRegisterer $registerer): self
    {
        $counter = new CounterVector(new MetricSubject(
            'linter',
            'rule_lint_state',
            'Rule lint state',
        ));

        $registerer->register($counter);

        return new self($counter);
    }

    public function handle(RuleWasSuccessfulEvent|RuleWasFailedEvent $event): void
    {
        if ($event instanceof RuleWasSuccessfulEvent) {
            $this
                ->counter
                ->add([
                    'rule' => $event->ruleName,
                    'state' => 'true',
                ])
                ->inc();

            return;
        }

        $this
            ->counter
            ->add([
                'rule' => $event->ruleName,
                'state' => 'fail',
            ])
            ->inc();
    }
}
