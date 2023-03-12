<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class TokenTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token::authenticate
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token::__construct
     */
    public function testAuthenticate(): void
    {
        $token = new Token('my-header', '123');

        $req = new Request('GET', 'http://site.ru');

        $req = $token->authenticate($req);

        self::assertEquals(['123'], $req->getHeader('my-header'));
    }
}
