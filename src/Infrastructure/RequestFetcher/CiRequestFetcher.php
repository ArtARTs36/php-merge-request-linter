<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\StringMetric;

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

        $this->metrics->add(
            new MetricSubject('used_ci_system', '[CI] Used CI System'),
            new StringMetric($ci->getName()),
        );

        return $ci->getCurrentlyMergeRequest();
    }
}
