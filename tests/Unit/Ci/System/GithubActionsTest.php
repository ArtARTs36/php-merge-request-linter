<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\System;

use ArtARTs36\MergeRequestLinter\CI\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Environment\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
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
     * @covers \ArtARTs36\MergeRequestLinter\CI\System\Github\GithubActions::is
     */
    public function testIs(array $env, bool $expected): void
    {
        self::assertEquals($expected, GithubActions::is(new MapEnvironment(new Map($env))));
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
     * @covers \ArtARTs36\MergeRequestLinter\Ci\System\Github\GithubActions::isMergeRequest
     */
    public function testIsMergeRequest(array $env, bool $expected): void
    {
        self::assertEquals($expected, $this->makeCi($env)->isMergeRequest());
    }

    private function makeCi(array $env): GithubActions
    {
        return new GithubActions(
            new GithubEnvironment(new MapEnvironment(new Map($env))),
            new class () implements GithubClient {
                public function getPullRequest(PullRequestInput $input): PullRequest
                {
                    // TODO: Implement getPullRequest() method.
                }
            },
        );
    }
}
