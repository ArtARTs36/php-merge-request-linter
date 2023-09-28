<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

/**
 * @codeCoverageIgnore
 */
enum MetricType: string
{
    case Gauge = 'Gauge';
    case Counter = 'Counter';
}
