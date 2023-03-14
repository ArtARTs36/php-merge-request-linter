<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HostAuthenticator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class HostAuthenticatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HostAuthenticator::authenticate
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HostAuthenticator::__construct
     */
    public function testAuthenticate(): void
    {
        $authenticator = new HostAuthenticator('site1.ru');

        $req = new Request('GET', 'http://site2.ru/page');

        $resultReq = $authenticator->authenticate($req);

        self::assertEquals('http://site1.ru/page', $resultReq->getUri()->__toString());
        self::assertEquals(['Host' => ['site1.ru']], $resultReq->getHeaders());
    }
}
