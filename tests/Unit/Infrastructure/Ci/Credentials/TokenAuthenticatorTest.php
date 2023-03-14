<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class TokenAuthenticatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator::authenticate
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator::__construct
     */
    public function testAuthenticate(): void
    {
        $token = new TokenAuthenticator('my-header', '123');

        $req = new Request('GET', 'http://site.ru');

        $req = $token->authenticate($req);

        self::assertEquals(['123'], $req->getHeader('my-header'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator::bearer
     */
    public function testBearer(): void
    {
        $token = TokenAuthenticator::bearer('123');

        $req = $token->authenticate(new Request('GET', 'http://site.ru'));

        self::assertEquals(['Bearer 123'], $req->getHeader('Authorization'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator::__debugInfo
     */
    public function testDebugInfo(): void
    {
        $info = TokenAuthenticator::bearer('123')->__debugInfo();

        self::assertNotEquals('123', $info['token']);
    }
}
