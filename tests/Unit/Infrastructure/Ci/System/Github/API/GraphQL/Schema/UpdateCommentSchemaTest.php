<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\UpdateCommentSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class UpdateCommentSchemaTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\UpdateCommentSchema::createQuery
     */
    public function testCreateQuery(): void
    {
        $schema = new UpdateCommentSchema();

        self::assertEquals(
            [
                'commentId' => '2',
                'body' => 'test-message',
            ],
            $schema->createQuery(new UpdateCommentInput(
                '',
                '2',
                'test-message',
            ))->variables,
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\UpdateCommentSchema::check
     */
    public function testCheck(): void
    {
        $schema = new UpdateCommentSchema();

        self::assertTrue(
            $schema->check([
                'data' => [
                    'updateIssueComment' => [
                        'issueComment' => [
                            'id' => '2',
                        ],
                    ],
                ],
            ], '2'),
        );
    }
}
