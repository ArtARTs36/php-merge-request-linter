<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Metrics;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\CollectorRegistry;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\MetricStorage;

class RequestMetricFlusher
{
    public function __construct(
        private readonly CollectorRegistry $metrics,
        private readonly MetricStorage     $storage,
    ) {
    }

    public function flush(MergeRequest $request): void
    {
        $transactionId = md5(sprintf('%s-%s', $request->uri, time()));

        $this->storage->commit($transactionId, $this->metrics->describe()->toArray());
    }
}
