<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequestState;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class PullRequestStateTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            ['OPEN', PullRequestState::Open],
            ['OPEN-1', PullRequestState::Unknown],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequestState::create
     * @dataProvider providerForTestCreate
     */
    public function testCreate(string $value, PullRequestState $expected): void
    {
        self::assertEquals($expected, PullRequestState::create($value));
    }
}
