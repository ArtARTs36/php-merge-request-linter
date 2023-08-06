<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\ContextLogger\LoggerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change\ChangeSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ClientTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::postComment
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::runQuery
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::__construct
     */
    public function testPostComment(): void
    {
        $client = $this->createClient(
            [
                [
                    'data' => [
                        'addComment' => [
                            'commentEdge' => [
                                'node' => [
                                    'id' => '3',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        );

        $commentId = $client->postComment(new AddCommentInput(
            'https://github.com/graphql',
            '1',
            'test-comment'
        ));

        self::assertEquals(3, $commentId);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::updateComment
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::runQuery
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::__construct
     */
    public function testUpdateComment(): void
    {
        $client = $this->createClient(
            [
                [
                    'data' => [
                        'updateIssueComment' => [
                            'issueComment' => [
                                'id' => '1',
                            ],
                        ],
                    ],
                ],
            ],
        );

        $client->updateComment(new UpdateCommentInput(
            'https://github.com/graphql',
            '1',
            'test-comment'
        ));

        $this->addToAssertionCount(1);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::updateComment
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::runQuery
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::__construct
     */
    public function testUpdateCommentNoUpdated(): void
    {
        $client = $this->createClient(
            [
                [
                    'data' => [
                        'updateIssueComment' => [
                            'issueComment' => [
                                'id' => '2',
                            ],
                        ],
                    ],
                ],
            ],
        );

        self::expectExceptionMessage('Comment no updated');

        $client->updateComment(new UpdateCommentInput(
            'https://github.com/graphql',
            '1',
            'test-comment'
        ));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::getCurrentUser
     */
    public function testGetCurrentUser(): void
    {
        $client = $this->createClient([
            [
                'data' => [
                    'viewer' => [
                        'login' => 'test',
                    ],
                ],
            ],
        ]);

        $viewer = $client->getCurrentUser('');

        self::assertEquals('test', $viewer->login);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client::getCommentsOnPullRequest
     */
    public function testGetCommentsOnPullRequest(): void
    {
        $client = $this->createClient([
            [
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
            ],
        ]);

        $commentList = $client->getCommentsOnPullRequest('', '');

        self::assertCount(1, $commentList->comments);
    }

    /**
     * @param array<string, array<mixed>> $responsesContents
     */
    private function createClient(
        array $responsesContents = [],
        ?ContextLogger $logger = null,
    ): Client {
        return new Client(
            MockClient::makeOfResponsesContents($responsesContents),
            new NullAuthenticator(),
            new PullRequestSchema(LocalClock::utc()),
            $logger ?? LoggerFactory::null(),
            new NativeJsonProcessor(),
            new ChangeSchema(new DiffMapper()),
        );
    }
}
