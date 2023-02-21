<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockGithubClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GithubActionsTest extends TestCase
{
    public function providerForTestIs(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['GITHUB_ACTIONS' => 'run'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIs
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::isCurrentlyWorking
     */
    public function testIs(array $env, bool $expected): void
    {
        self::assertEquals($expected, $this->makeCi($env)->isCurrentlyWorking());
    }

    public function providerForTestIsMergeRequest(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['GITHUB_REF_NAME' => '1/merge'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::isCurrentlyMergeRequest
     */
    public function testIsMergeRequest(array $env, bool $expected): void
    {
        self::assertEquals($expected, $this->makeCi($env)->isCurrentlyMergeRequest());
    }

    private function makeCi(array $env): GithubActions
    {
        return new GithubActions(
            new GithubEnvironment(new MapEnvironment(new ArrayMap($env))),
            new MockGithubClient(),
        );
    }
}
