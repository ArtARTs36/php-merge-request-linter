<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

enum MetricType: string
{
    case Gauge = 'Gauge';
    case Counter = 'Counter';
}
