<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\CompositeAuthenticator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\CounterAuthenticator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class CompositeAuthenticatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\CompositeAuthenticator::authenticate
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\CompositeAuthenticator::__construct
     */
    public function testAuthenticate(): void
    {
        $authenticator = new CompositeAuthenticator($subs = [
            new CounterAuthenticator(),
            new CounterAuthenticator(),
        ]);

        $authenticator->authenticate(new Request('GET', 'http://site.ru'));

        $allCalled = true;

        foreach ($subs as $sub) {
            if ($sub->calls === 0) {
                $allCalled = false;

                break;
            }
        }

        self::assertTrue($allCalled, 'Sub authenticators not called');
    }
}
