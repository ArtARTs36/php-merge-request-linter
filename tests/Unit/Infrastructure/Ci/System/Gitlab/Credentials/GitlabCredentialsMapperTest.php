<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\CompositeTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GitlabCredentialsMapperTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::__construct
     */
    public function testMap(): void
    {
        $mapper = new GitlabCredentialsMapper(new CompositeTransformer([]));

        self::assertInstanceOf(HeaderAuthenticator::class, $mapper->map([
            'token' => '12',
        ]));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::__construct
     */
    public function testMapOnInvalidCredentials(): void
    {
        $mapper = new GitlabCredentialsMapper(new CompositeTransformer([]));

        self::expectException(InvalidCredentialsException::class);

        $mapper->map([]);
    }
}
