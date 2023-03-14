<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\Env;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\Repo;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\VarName;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class BitbucketEnvironmentTest extends TestCase
{
    public function providerForTestIsWorking(): array
    {
        return [
            [
                [VarName::ProjectKey->value => 'test-project'],
                true,
            ],
            [
                [],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment::isWorking
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment::__construct
     * @dataProvider providerForTestIsWorking
     */
    public function testIsWorking(array $vars, bool $expected): void
    {
        $env = new BitbucketEnvironment(new MapEnvironment(new ArrayMap($vars)));

        self::assertEquals($expected, $env->isWorking());
    }

    public function providerForTestGetRepo(): array
    {
        return [
            [
                [
                    VarName::Workspace->value => 'super-owner',
                    VarName::RepoName->value  => 'super-repo',
                ],
                new Repo('super-owner', 'super-repo'),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment::getRepo
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment::__construct
     * @dataProvider providerForTestGetRepo
     */
    public function testGetRepo(array $vars, Repo $repo): void
    {
        $env = new BitbucketEnvironment(new MapEnvironment(new ArrayMap($vars)));

        self::assertEquals($repo, $env->getRepo());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment::getPullRequestId
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment::__construct
     */
    public function testGetPullRequestId(): void
    {
        $env = new BitbucketEnvironment(new MapEnvironment(new ArrayMap([
            VarName::PullRequestId->value => 5,
        ])));

        self::assertEquals(5, $env->getPullRequestId());
    }
}
