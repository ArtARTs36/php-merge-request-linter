<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\System\GitlabCi;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Environment\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Support\Map;
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

    protected function makeCi(array $env): GitlabCi
    {
        return new GitlabCi(new EmptyCredentials(), $this->makeEnvironment($env), new NullClient());
    }
}
