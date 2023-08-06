<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab\API\Objects;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class UserTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\User::__debugInfo
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\User::__construct
     */
    public function testDebugInfo(): void
    {
        $user = new User('1', 'test');

        self::assertEquals([
            'login' => 't**t',
        ], $user->__debugInfo());
    }
}
