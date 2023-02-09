<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\System;

use ArtARTs36\MergeRequestLinter\CI\System\Exceptions\InvalidEnvironmentVariableValueException;
use ArtARTs36\MergeRequestLinter\CI\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\CI\System\Github\Env\VarName;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\EnvironmentVariableNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\NullEnvironment;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GithubEnvironmentTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\CI\System\Github\Env\GithubEnvironment::getMergeRequestId
     */
    public function testGetMergeRequestIdOnEnvironmentVariableNotFoundException(): void
    {
        self::expectException(EnvironmentVariableNotFoundException::class);

        $env = new GithubEnvironment(new NullEnvironment());

        $env->getMergeRequestId();
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\CI\System\Github\Env\GithubEnvironment::getMergeRequestId
     */
    public function testGetMergeRequestIdOnInvalidEnvironmentVariableValueException(): void
    {
        self::expectException(InvalidEnvironmentVariableValueException::class);

        $env = new GithubEnvironment(new MapEnvironment(new ArrayMap([
            VarName::RefName->value => '',
        ])));

        $env->getMergeRequestId();
    }
}
