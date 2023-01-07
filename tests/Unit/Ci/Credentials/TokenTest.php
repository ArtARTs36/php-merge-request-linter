<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\CI\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TokenTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Ci\Credentials\Token::getToken
     * @covers \ArtARTs36\MergeRequestLinter\Ci\Credentials\Token::__construct
     */
    public function testGetToken(): void
    {
        $token = new Token('123');

        self::assertEquals('123', $token->getToken());
    }
}
