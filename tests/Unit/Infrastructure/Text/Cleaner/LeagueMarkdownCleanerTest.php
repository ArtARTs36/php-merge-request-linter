<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Text\Cleaner;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use League\CommonMark\CommonMarkConverter;

final class LeagueMarkdownCleanerTest extends TestCase
{
    public function providerForTestClean(): array
    {
        return [
            ['## Title', 'Title'],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner::clean
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner::__construct
     * @dataProvider providerForTestClean
     */
    public function testClean(string $input, string $expected): void
    {
        $cleaner = new LeagueMarkdownCleaner(new CommonMarkConverter());

        self::assertEquals($expected, $cleaner->clean($input)->__toString());
    }
}
