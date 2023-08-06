<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidResponseException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\ViewerSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ViewerSchemaTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\ViewerSchema::createQuery
     */
    public function testCreateQuery(): void
    {
        $schema = new ViewerSchema();

        $query = $schema->createQuery();

        self::assertEquals([], $query->variables);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\ViewerSchema::createViewer
     */
    public function testCreateViewer(): void
    {
        $schema = new ViewerSchema();

        $user = $schema->createViewer([
            'data' => [
                'viewer' => [
                    'login' => 'test',
                ],
            ],
        ]);

        self::assertEquals('test', $user->login);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\ViewerSchema::createViewer
     */
    public function testCreateViewerFailed(): void
    {
        $schema = new ViewerSchema();

        self::expectException(InvalidResponseException::class);

        $schema->createViewer([
            'data' => [
                'viewer' => [
                    'login' => 1,
                ],
            ],
        ]);
    }
}
