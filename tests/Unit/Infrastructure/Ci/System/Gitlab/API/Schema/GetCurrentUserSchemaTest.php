<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Schema\GetCurrentUserSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GetCurrentUserSchemaTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Schema\GetCurrentUserSchema::createUser
     */
    public function testCreateUser(): void
    {
        $schema = new GetCurrentUserSchema();

        $user = $schema->createUser([
            'id' => 12,
            'username' => 'test',
        ]);

        self::assertEquals(
            [
                'id' => 12,
                'login' => 'test',
            ],
            [
                'id' => $user->id,
                'login' => $user->login,
            ],
        );
    }
}
