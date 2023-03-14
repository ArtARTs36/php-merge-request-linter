<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\AuthenticatorProxy;
use GuzzleHttp\Psr7\Request;

final class AuthenticatorProxyTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\AuthenticatorProxy::authenticate
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\AuthenticatorProxy::authenticator
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\AuthenticatorProxy::__construct
     */
    public function testAuthenticate(): void
    {
        $factoryCalledCounter = 0;

        $proxy = new AuthenticatorProxy(function () use (&$factoryCalledCounter) {
            ++$factoryCalledCounter;

            return new NullAuthenticator();
        });

        $proxy->authenticate(new Request('GET', 'http://site.ru'));
        $proxy->authenticate(new Request('GET', 'http://site.ru'));

        self::assertEquals(1, $factoryCalledCounter);
    }
}
