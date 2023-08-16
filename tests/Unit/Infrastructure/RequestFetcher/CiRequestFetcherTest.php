<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CiRequestFetcherTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher::fetch
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher::__construct
     */
    public function testFetchAddMetric(): void
    {
        $fetcher = new CiRequestFetcher(
            new MockCiSystemFactory(new MockCi($this->makeMergeRequest())),
            $metrics = new MemoryMetricManager(LocalClock::utc()),
        );

        $fetcher->fetch();

        self::assertEquals('used_ci_system', $metrics->describe()->first()->subject->key);
    }
}
