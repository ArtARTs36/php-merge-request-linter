<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\System;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
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
            new class () implements GithubClient {
                public function getPullRequest(PullRequestInput $input): PullRequest
                {
                    // TODO: Implement getPullRequest() method.
                }

                public function getTags(TagsInput $input): TagCollection
                {
                    // TODO: Implement getTags() method.
                }
            },
        );
    }
}
