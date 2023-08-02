<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\AddCommentSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AddCommentSchemaTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\AddCommentSchema::createMutation
     */
    public function testCreateMutation(): void
    {
        $schema = new AddCommentSchema();

        $mutation = $schema->createMutation(new AddCommentInput('', '2', 'test-message'));

        self::assertEquals(
            [
                'requestId' => '2',
                'message' => 'test-message',
            ],
            $mutation->variables,
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\AddCommentSchema::createComment
     */
    public function testCreateComment(): void
    {
        $raw = [
            'data' => [
                'addComment' => [
                    'commentEdge' => [
                        'node' => [
                            'id' => '3',
                        ],
                    ],
                ],
            ],
        ];

        $schema = new AddCommentSchema();

        self::assertEquals(
            '3',
            $schema->createComment($raw)->id,
        );
    }
}
