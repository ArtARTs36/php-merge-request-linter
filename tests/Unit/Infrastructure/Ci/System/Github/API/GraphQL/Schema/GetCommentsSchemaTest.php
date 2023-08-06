<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\GetCommentsSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GetCommentsSchemaTest extends TestCase
{
    public function providerForTestCreateQuery(): array
    {
        return [
            [
                'https://pr.com/',
                null,
                [
                    'url' => 'https://pr.com/',
                ],
            ],
            [
                'https://pr.com/',
                '500',
                [
                    'url' => 'https://pr.com/',
                    'after' => '500',
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\GetCommentsSchema::createQuery
     *
     * @dataProvider providerForTestCreateQuery
     */
    public function testCreateQuery(string $url, ?string $after, array $expectedQueryParams): void
    {
        $schema = new GetCommentsSchema();

        self::assertEquals(
            $expectedQueryParams,
            $schema->createQuery($url, $after)->variables,
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\GetCommentsSchema::createCommentList
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\GetCommentsSchema::doCreateComments
     */
    public function testCreateCommentList(): void
    {
        $schema = new GetCommentsSchema();

        $commentList = $schema->createCommentList([
            'data' => [
                'resource' => [
                    'comments' => [
                        'nodes' => [
                            [
                                'id' => '12',
                                'author' => [
                                    'login' => 'dev',
                                ],
                                'body' => 'test-comment',
                            ],
                        ],
                        'pageInfo' => [
                            'hasNextPage' => true,
                            'endCursor' => null,
                        ],
                    ],
                ],
            ],
        ]);

        self::assertCount(1, $commentList->comments);
    }

    public function providerForTestCreateCommentListOnResponseInvalid(): array
    {
        return [
            [
                'Given invalid response: data.resource.comments.nodes must be array',
                [
                    'data' => [
                        'resource' => [
                            'comments' => [
                                'nodes' => [
                                    true,
                                ],
                                'pageInfo' => [
                                    'hasNextPage' => true,
                                    'endCursor' => null,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'Given invalid response: Array[data] doesnt have path "resource"',
                [
                    'data' => [
                        '_resource' => [ // expected "resource"
                            'comments' => [
                                'nodes' => [
                                    true,
                                ],
                                'pageInfo' => [
                                    'hasNextPage' => true,
                                    'endCursor' => null,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\GetCommentsSchema::createCommentList
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\GetCommentsSchema::doCreateComments
     *
     * @dataProvider providerForTestCreateCommentListOnResponseInvalid
     */
    public function testCreateCommentListOnResponseInvalid(string $expectedExceptionMessage, array $response): void
    {
        $schema = new GetCommentsSchema();

        self::expectExceptionMessage($expectedExceptionMessage);

        $schema->createCommentList($response);
    }
}
