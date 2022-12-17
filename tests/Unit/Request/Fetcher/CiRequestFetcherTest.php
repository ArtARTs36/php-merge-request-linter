<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Request\Fetcher;

use ArtARTs36\MergeRequestLinter\Exception\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Request\Fetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CiRequestFetcherTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Request\Fetcher\CiRequestFetcher::fetch
     */
    public function testFetchOnCurrentlyNotMergeRequestException(): void
    {
        $fetcher = new CiRequestFetcher(
            new MockCiSystemFactory(new MockCi([
                'is_pull_request' => false,
            ]))
        );

        self::expectException(CurrentlyNotMergeRequestException::class);

        $fetcher->fetch();
    }
}
