<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\GetCommentsSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GetCommentsSchemaTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\GetCommentsSchema::createCommentList
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\GetCommentsSchema::doCreateCommentList
     */
    public function testCreateCommentListOnValuesItemNotArray(): void
    {
        $schema = new GetCommentsSchema();

        self::expectExceptionMessage('Creating comment list was failed: response[values] must be array');

        $schema->createCommentList([
            'values' => [
                'item',
            ],
        ]);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\GetCommentsSchema::createCommentList
     */
    public function testCreateCommentList(): void
    {
        $schema = new GetCommentsSchema();

        $commentList = $schema->createCommentList([
            'values' => [
                [
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
                ],
            ],
            'page' => 1,
        ]);

        $comment = $commentList->comments->first();

        self::assertEquals(
            [1, $id, $url, $content, $authorAccountId],
            [$commentList->page, $comment->id, $comment->url, $comment->content, $comment->authorAccountId],
        );
    }
}
