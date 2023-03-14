<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\BasicBase64Authenticator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class BasicBase64AuthenticatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\BasicBase64Authenticator::authenticate
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\BasicBase64Authenticator::__construct
     */
    public function testAuthenticate(): void
    {
        $authenticator = new BasicBase64Authenticator('dev', 'password');

        $req = new Request('GET', 'http://site.ru');

        $resultReq = $authenticator->authenticate($req);

        self::assertEquals([
            'Authorization' => ['Basic ZGV2OnBhc3N3b3Jk'],
            'Host' => ['site.ru'],
        ], $resultReq->getHeaders());
    }
}
