<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\CommentList;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockGithubClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GithubActionsTest extends TestCase
{
    public function providerForTestIs(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['GITHUB_ACTIONS' => 'run'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIs
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::isCurrentlyWorking
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::__construct
     */
    public function testIsCurrentlyWorking(array $env, bool $expected): void
    {
        self::assertEquals($expected, $this->makeCi($env)->isCurrentlyWorking());
    }

    public function providerForTestIsMergeRequest(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['GITHUB_REF_NAME' => '1/merge'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::isCurrentlyMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::__construct
     */
    public function testIsCurrentlyMergeRequest(array $env, bool $expected): void
    {
        self::assertEquals($expected, $this->makeCi($env)->isCurrentlyMergeRequest());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::updateComment
     */
    public function testUpdateComment(): void
    {
        $ci = $this->makeCi([
            'GITHUB_REF_NAME' => '1/merge',
            'GITHUB_GRAPHQL_URL' => '',
        ]);

        $ci->updateComment(new Comment('', ''));

        $this->addToAssertionCount(1);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::postCommentOnMergeRequest
     */
    public function testPostCommentOnMergeRequest(): void
    {
        $ci = $this->makeCi([
            'GITHUB_REF_NAME' => '1/merge',
            'GITHUB_GRAPHQL_URL' => '',
        ]);

        $ci->postCommentOnMergeRequest($this->makeMergeRequest(), 'test');

        $this->addToAssertionCount(1);
    }

    public function providerForTestGetFirstCommentOnMergeRequestByCurrentUser(): array
    {
        return [
            [
                Viewer::make('test4'),
                new CommentList(
                    new Arrayee([
                        new \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment(
                            '1',
                            'test1',
                            'test-message-1',
                        ),
                        new \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment(
                            '2',
                            'test2',
                            'test-message-2',
                        ),
                        new \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment(
                            '3',
                            'test3',
                            'test-message-3',
                        ),
                    ]),
                    false,
                    '1',
                ),
                null,
            ],
            [
                Viewer::make('test2'),
                new CommentList(
                    new Arrayee([
                        new \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment(
                            '1',
                            'test1',
                            'test-message-1',
                        ),
                        new \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment(
                            '2',
                            'test2',
                            'test-message-2',
                        ),
                        new \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Comment(
                            '3',
                            'test3',
                            'test-message-3',
                        ),
                    ]),
                    true,
                    '1',
                ),
                new Comment('2', 'test-message-2'),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::getFirstCommentOnMergeRequestByCurrentUser
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::findCommentByUser
     *
     * @dataProvider providerForTestGetFirstCommentOnMergeRequestByCurrentUser
     */
    public function testGetFirstCommentOnMergeRequestByCurrentUser(Viewer $user, CommentList $commentList, ?Comment $expectedComment): void
    {
        $ci = $this->makeCi([
            'GITHUB_REF_NAME' => '1/merge',
            'GITHUB_GRAPHQL_URL' => '',
        ], new MockGithubClient(
            user: $user,
            comments: $commentList,
        ));

        $comment = $ci->getFirstCommentOnMergeRequestByCurrentUser($this->makeMergeRequest());

        self::assertEquals($expectedComment, $comment);
    }

    private function makeCi(array $env, ?GithubClient $githubClient = null): GithubActions
    {
        return new GithubActions(
            new GithubEnvironment(new MapEnvironment(new ArrayMap($env))),
            $githubClient ?? new MockGithubClient(),
        );
    }
}
