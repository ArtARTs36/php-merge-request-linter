<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

abstract class LabeledCollector extends AbstractCollector
{
    /**
     * @param array<string, string> $labels
     */
    public function __construct(
        MetricSubject $subject,
        protected readonly array $labels,
    ) {
        parent::__construct($subject);
    }
}
