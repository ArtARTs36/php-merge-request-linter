<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\Env;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidEnvironmentVariableValueException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\VarName;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GithubEnvironmentTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment::getMergeRequestId
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment::__construct
     */
    public function testGetMergeRequestIdOnInvalidEnvironmentVariableValueException(): void
    {
        self::expectException(InvalidEnvironmentVariableValueException::class);

        $env = new GithubEnvironment(new MapEnvironment(new ArrayMap([
            VarName::RefName->value => '/merge',
        ])));

        $env->getMergeRequestId();
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment::getMergeRequestId
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment::__construct
     */
    public function testGetMergeRequestIdOnNotMergeRef(): void
    {
        $env = new GithubEnvironment(new MapEnvironment(new ArrayMap([
            VarName::RefName->value => '',
        ])));

        self::assertNull($env->getMergeRequestId());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment::extractRepo
     */
    public function testExtractRepo(): void
    {
        $env = new GithubEnvironment(new MapEnvironment(new ArrayMap([
            VarName::Repository->value => 'user/repo',
        ])));

        $repo = $env->extractRepo();

        self::assertEquals(['user', 'repo'], [$repo->owner, $repo->name]);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment::extractRepo
     */
    public function testExtractRepoOnInvalidValue(): void
    {
        $env = new GithubEnvironment(new MapEnvironment(new ArrayMap([
            VarName::Repository->value => 'user-repo',
        ])));

        self::expectException(InvalidEnvironmentVariableValueException::class);

        $env->extractRepo();
    }
}
