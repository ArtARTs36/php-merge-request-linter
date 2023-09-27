<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\GettingMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;

final readonly class CiRequestFetcher implements MergeRequestFetcher
{
    public function __construct(
        private CiSystemFactory $systems,
        private MetricManager   $metrics,
    ) {
    }

    public function fetch(): MergeRequest
    {
        $ci = $this->systems->createCurrently();

        $this->metrics->registerWithSample(
            new MetricSubject('ci', 'used_systems', 'Used CI System'),
            IncCounter::one(['ci' => $ci->getName()]),
        );

        try {
            return $ci->getCurrentlyMergeRequest();
        } catch (CurrentlyNotMergeRequestException $e) {
            throw new CurrentlyNotMergeRequestException(
                sprintf('Fetch current merge request from %s was failed: %s', $ci->getName(), $e->getMessage()),
                previous: $e,
            );
        } catch (GettingMergeRequestException $e) {
            throw new FetchMergeRequestException(
                sprintf('Fetch current merge request from %s was failed: %s', $ci->getName(), $e->getMessage()),
                previous: $e,
            );
        }
    }
}
