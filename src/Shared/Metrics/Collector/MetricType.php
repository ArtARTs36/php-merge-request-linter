<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

enum MetricType: string
{
    case Gauge = 'Gauge';
    case Counter = 'Counter';
}
