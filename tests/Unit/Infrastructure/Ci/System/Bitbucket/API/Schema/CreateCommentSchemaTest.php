<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\CreateCommentSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CreateCommentSchemaTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\CreateCommentSchema::createComment
     */
    public function testCreateComment(): void
    {
        $schema = new CreateCommentSchema();

        $comment = $schema->createComment([
            'id' => $id = 1,
            'links' => [
                'self' => [
                    'href' => $url = 'http://url.url',
                ],
            ],
            'content' => [
                'raw' => $content = 'test-comment',
            ],
            'user' => [
                'account_id' => $authorAccountId = '2',
            ],
        ]);

        self::assertEquals(
            [$id, $url, $content, $authorAccountId],
            [$comment->id, $comment->url, $comment->content, $comment->authorAccountId],
        );
    }
}
