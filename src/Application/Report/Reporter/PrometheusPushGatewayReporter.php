<?php

namespace ArtARTs36\MergeRequestLinter\Application\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway\Metric;
use ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway\PushGateway;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;

class PrometheusPushGatewayReporter implements Reporter
{
    public function __construct(
        private readonly MetricManager $metrics,
        private readonly PushGateway $client,
    ) {
    }

    public function report(MergeRequest $request, LintResult $result): void
    {
        $jobId = sprintf('%s-%s', $request->uri, time());
        $jobIdHash = md5($jobId);

        $this->client->push($jobIdHash, $this->collectMetrics($request, $result));
    }

    /**
     * @return array<Metric>
     */
    private function collectMetrics(MergeRequest $request, LintResult $result): array
    {
        $labels = ['repo' => (string) $request->uri, 'request_id' => $request->id];
        $metrics = [];

        $metrics[] = Metric::gauge('mr_linter_lint_state', 'MR Linter: lint state', $labels, $result->state->value);
        $metrics[] = Metric::gauge('mr_linter_lint_duration', 'MR Linter: lint duration', $labels, $result->duration->seconds);
        $metrics[] = Metric::gauge('mr_linter_lint_notes', 'MR Linter: lint duration', $labels, $result->notes->count());

        return $metrics;
    }
}
