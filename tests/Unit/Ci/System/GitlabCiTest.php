<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\System\GitlabCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\EmptyCredentials;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GitlabCiTest extends TestCase
{
    public function providerForTestIs(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['GITLAB_CI' => 'true'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIs
     * @covers \ArtARTs36\MergeRequestLinter\Ci\System\GitlabCi::is
     */
    public function testIs(array $env, bool $expected): void
    {
        self::assertEquals($expected, GitlabCi::is($this->makeEnvironment($env)));
    }

    public function providerForTestIsMergeRequest(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['CI_MERGE_REQUEST_IID' => 1],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Ci\System\GitlabCi::isMergeRequest
     */
    public function testIsMergeRequest(array $env, bool $expected): void
    {
        self::assertEquals($expected, $this->makeCi($env)->isMergeRequest());
    }

    private function makeCi(array $env): GitlabCi
    {
        return new GitlabCi(new EmptyCredentials(), $this->makeEnvironment($env), new NullClient());
    }
}
