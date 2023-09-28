<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

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
            $metrics = new MemoryRegistry(LocalClock::utc()),
        );

        $fetcher->fetch();

        self::assertEquals('used_ci_system', $metrics->describe()->first()->subject->key);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher::fetch
     */
    public function testFetchOnCurrentlyNotMergeRequestException(): void
    {
        $fetcher = new CiRequestFetcher(
            new MockCiSystemFactory(new MockCi()),
            new MemoryRegistry(LocalClock::utc()),
        );

        self::expectExceptionMessageMatches('/Fetch current merge request from (.*) was failed/i');

        $fetcher->fetch();
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher::fetch
     */
    public function testFetchOnGettingMergeRequestException(): void
    {
        $ci = $this->createMock(CiSystem::class);
        $ci
            ->expects(new InvokedCount(1))
            ->method('getCurrentlyMergeRequest')
            ->willThrowException(new FetchMergeRequestException());

        $fetcher = new CiRequestFetcher(
            new MockCiSystemFactory($ci),
            new MemoryRegistry(LocalClock::utc()),
        );

        self::expectExceptionMessageMatches('/Fetch current merge request from (.*) was failed/i');

        $fetcher->fetch();
    }
}
