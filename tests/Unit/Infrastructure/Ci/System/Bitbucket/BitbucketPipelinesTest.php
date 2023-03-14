<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\VarName;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockClient;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Psr\Log\NullLogger;

final class BitbucketPipelinesTest extends TestCase
{
    public function providerForTestIsCurrentlyWorking(): array
    {
        return [
            [
                [
                    VarName::ProjectKey->value => 'super-project',
                ],
                true,
            ],
            [
                [],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::isCurrentlyWorking
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::__construct
     * @dataProvider providerForTestIsCurrentlyWorking
     */
    public function testIsCurrentlyWorking(array $vars, bool $expected): void
    {
        $ci = $this->mockCi($vars);

        self::assertEquals($expected, $ci->isCurrentlyWorking());
    }

    public function providerForTestIsCurrentlyMergeRequest(): array
    {
        return [
            [
                [
                    VarName::PullRequestId->value => 1,
                ],
                true,
            ],
            [
                [],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::isCurrentlyMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::__construct
     * @dataProvider providerForTestIsCurrentlyMergeRequest
     */
    public function testIsCurrentlyMergeRequest(array $vars, bool $expected): void
    {
        $ci = $this->mockCi($vars);

        self::assertEquals($expected, $ci->isCurrentlyMergeRequest());
    }

    private function mockCi(array $env): BitbucketPipelines
    {
        return new BitbucketPipelines(
            new Client(
                new NullAuthenticator(),
                new MockClient(),
                new NullLogger(),
            ),
            new BitbucketEnvironment(new MapEnvironment(
                new ArrayMap($env),
            )),
            new MockMarkdownCleaner(),
        );
    }
}
