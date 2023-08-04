<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\CreateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Psr\Log\NullLogger;

final class ClientTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client::getCurrentUser
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client::__construct
     */
    public function testGetCurrentUser(): void
    {
        $client = $this->createClient([
            Client::URL_CURRENT_USER => [
                'display_name' => 'test',
                'account_id' => '1',
            ],
        ]);

        $user = $client->getCurrentUser();

        self::assertEquals(
            ['test', '1'],
            [$user->displayName, $user->accountId],
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client::postComment
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client::__construct
     */
    public function testPostComment(): void
    {
        $client = $this->createClient([
            'https://api.bitbucket.org/2.0/repositories/owner/repo/pullrequests/1/comments' => [
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
        ]);

        $comment = $client->postComment(new CreateCommentInput(
            'owner',
            'repo',
            1,
            'test-comment',
        ));

        self::assertEquals(
            [$id, $url, $content, $authorAccountId],
            [$comment->id, $comment->url, $comment->content, $comment->authorAccountId],
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client::updateComment
     */
    public function testUpdateComment(): void
    {
        $client = $this->createClient([
            'https://api.bitbucket.org/2.0/repositories/owner/repo/pullrequests/1/comments/2' => [
                'id' => $id = 2,
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
        ]);

        $comment = $client->updateComment(new UpdateCommentInput(
            'owner',
            'repo',
            1,
            '2',
            'test-comment',
        ));

        self::assertEquals(
            [$id, $url, $content, $authorAccountId],
            [$comment->id, $comment->url, $comment->content, $comment->authorAccountId],
        );
    }

    /**
     * @param array<string, array<mixed>> $responsesContents
     */
    private function createClient(array $responsesContents): Client
    {
        return new Client(
            new NullAuthenticator(),
            MockClient::makeOfResponsesContents($responsesContents),
            new NullLogger(),
            new NativeJsonProcessor(),
            new PullRequestSchema(
                LocalClock::utc(),
            ),
        );
    }
}
