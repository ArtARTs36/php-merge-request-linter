<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\Manager\MemoryMetricManager;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CiRequestFetcherTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher::fetch
     */
    public function testFetchOnCurrentlyNotMergeRequestException(): void
    {
        $fetcher = new CiRequestFetcher(
            new MockCiSystemFactory(new MockCi([
                'is_pull_request' => false,
            ])),
            new NullMetricManager(),
        );

        self::expectException(CurrentlyNotMergeRequestException::class);

        $fetcher->fetch();
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher::fetch
     */
    public function testFetchAddMetric(): void
    {
        $fetcher = new CiRequestFetcher(
            new MockCiSystemFactory(new MockCi([
                'is_pull_request' => true,
            ], $this->makeMergeRequest())),
            $metrics = new MemoryMetricManager(),
        );

        $fetcher->fetch();

        self::assertEquals('used_ci_system', $metrics->describe()->first()->subject->key);
    }
}
