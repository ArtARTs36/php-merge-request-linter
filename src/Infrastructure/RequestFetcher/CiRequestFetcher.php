<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Contracts\Request\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Exception\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Value\StringMetric;

class CiRequestFetcher implements MergeRequestFetcher
{
    public function __construct(
        private readonly CiSystemFactory $systems,
        private readonly MetricManager   $metrics,
    ) {
        //
    }

    public function fetch(): MergeRequest
    {
        $ci = $this->systems->createCurrently();

        if (! $ci->isCurrentlyMergeRequest()) {
            throw new CurrentlyNotMergeRequestException();
        }

        $this->metrics->add(
            new MetricSubject('used_ci_system', '[CI] Used CI System'),
            new StringMetric($ci->getName()),
        );

        return $ci->getCurrentlyMergeRequest();
    }
}
