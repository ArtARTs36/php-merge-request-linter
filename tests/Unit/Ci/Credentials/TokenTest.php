<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Ci\Credentials\OnlyToken;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TokenTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Ci\Credentials\OnlyToken::getToken
     */
    public function testGetToken(): void
    {
        $token = new OnlyToken('123');

        self::assertEquals('123', $token->getToken());
    }
}
