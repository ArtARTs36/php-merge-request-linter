<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Ci\Credentials\GitlabCredentials;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Gitlab\Client;

final class GitlabCredentialsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Ci\Credentials\GitlabCredentials::fromHttpToken
     */
    public function testFromHttpToken(): void
    {
        $credentials = GitlabCredentials::fromHttpToken('1234');

        self::assertEquals('1234', $credentials->token);
        self::assertEquals(Client::AUTH_HTTP_TOKEN, $credentials->method);
    }
}
