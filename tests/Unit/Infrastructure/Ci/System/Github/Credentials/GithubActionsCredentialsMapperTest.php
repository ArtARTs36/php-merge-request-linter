<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials\GithubActionsCredentialsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\CompositeTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GithubActionsCredentialsMapperTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials\GithubActionsCredentialsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials\GithubActionsCredentialsMapper::__construct
     */
    public function testMap(): void
    {
        $mapper = new GithubActionsCredentialsMapper(new CompositeTransformer([]));

        self::assertInstanceOf(HeaderAuthenticator::class, $mapper->map([
            'token' => '12',
        ]));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials\GithubActionsCredentialsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials\GithubActionsCredentialsMapper::__construct
     */
    public function testMapOnInvalidCredentials(): void
    {
        $mapper = new GithubActionsCredentialsMapper(new CompositeTransformer([]));

        self::expectException(InvalidCredentialsException::class);

        $mapper->map([]);
    }
}
