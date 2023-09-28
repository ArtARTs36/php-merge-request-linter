<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\GettingMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricRegisterer;

final readonly class CiRequestFetcher implements MergeRequestFetcher
{
    public function __construct(
        private CiSystemFactory  $systems,
        private MetricRegisterer $metrics,
    ) {
    }

    public function fetch(): MergeRequest
    {
        $ci = $this->systems->createCurrently();

        $metric = CounterVector::once(
            new MetricSubject('ci', 'used_systems', 'Used CI systems', 'Used CI systems: :ci:'),
            ['ci' => $ci->getName()],
        );

        $this->metrics->register($metric);

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
