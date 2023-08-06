<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\GetCurrentUserSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GetCurrentUserSchemaTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\GetCurrentUserSchema::createUser
     */
    public function testCreateUser(): void
    {
        $schema = new GetCurrentUserSchema();

        $user = $schema->createUser([
            'display_name' => 'test',
            'account_id' => '1',
        ]);

        self::assertEquals(
            ['test', '1'],
            [$user->displayName, $user->accountId],
        );
    }
}
