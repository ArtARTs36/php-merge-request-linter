<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\RequestFetcher;

use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\MemoryRequestFetcher;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MemoryRequestFetcherTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\MemoryRequestFetcher::fetch
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\MemoryRequestFetcher::__construct
     */
    public function testFetch(): void
    {
        $fetcher = new MemoryRequestFetcher($request = $this->makeMergeRequest());

        self::assertEquals($request, $fetcher->fetch());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\MemoryRequestFetcher::useRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\MemoryRequestFetcher::fetch
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\MemoryRequestFetcher::__construct
     */
    public function testUseRequest(): void
    {
        $fetcher = new MemoryRequestFetcher($this->makeMergeRequest());

        $fetcher->useRequest($request2 = $this->makeMergeRequest());

        self::assertEquals($request2, $fetcher->fetch());
    }
}
