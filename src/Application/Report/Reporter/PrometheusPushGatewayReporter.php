<?php

namespace ArtARTs36\MergeRequestLinter\Application\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\PushGateway;

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

        $this->client->push($jobIdHash, $this->metrics->describe());
    }
}
