<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class TokenAuthenticatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator::authenticate
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator::__construct
     */
    public function testAuthenticate(): void
    {
        $token = new HeaderAuthenticator('my-header', '123');

        $req = new Request('GET', 'http://site.ru');

        $req = $token->authenticate($req);

        self::assertEquals(['123'], $req->getHeader('my-header'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator::bearer
     */
    public function testBearer(): void
    {
        $token = HeaderAuthenticator::bearer('123');

        $req = $token->authenticate(new Request('GET', 'http://site.ru'));

        self::assertEquals(['Bearer 123'], $req->getHeader('Authorization'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator::__debugInfo
     */
    public function testDebugInfo(): void
    {
        $info = HeaderAuthenticator::bearer('123')->__debugInfo();

        self::assertNotEquals('123', $info['header']['value']);
    }
}
