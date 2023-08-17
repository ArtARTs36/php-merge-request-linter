<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\MergeRequestNotFoundException;
use ArtARTs36\MergeRequestLinter\Domain\CI\PostCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\CommentList;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\VarName;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\ForbiddenException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpRequestException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockGithubClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

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

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::updateComment
     */
    public function testUpdateComment(): void
    {
        $ci = $this->makeCi([
            'GITHUB_REF_NAME' => '1/merge',
            'GITHUB_GRAPHQL_URL' => '',
        ]);

        $ci->updateComment(new Comment('', '', '1'));

        $this->addToAssertionCount(1);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::updateComment
     */
    public function testUpdateCommentOnRequestException(): void
    {
        $client = new MockGithubClient(
            updateCommentResponse: new HttpRequestException(new Request('GET', 'http://google.com')),
        );

        $ci = $this->makeCi([
            'GITHUB_REF_NAME' => '1/merge',
            'GITHUB_GRAPHQL_URL' => '',
        ], $client);

        self::expectException(PostCommentException::class);

        $ci->updateComment(new Comment('', '', '1'));
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

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::postCommentOnMergeRequest
     */
    public function testPostCommentOnMergeRequestOnRequestException(): void
    {
        $client = new MockGithubClient(
            postCommentOnMergeRequestResponse: new HttpRequestException(new Request('GET', 'http://google.com')),
        );

        $ci = $this->makeCi([
            'GITHUB_REF_NAME' => '1/merge',
            'GITHUB_GRAPHQL_URL' => '',
        ], $client);

        self::expectException(PostCommentException::class);

        $ci->postCommentOnMergeRequest($this->makeMergeRequest(), 'test');
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
                new Comment('2', 'test-message-2', '1'),
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

        $comment = $ci->getFirstCommentOnMergeRequestByCurrentUser($this->makeMergeRequest([
            'id' => 1,
        ]));

        self::assertEquals($expectedComment, $comment);
    }

    public function providerForTestGetCurrentlyMergeRequestOnException(): array
    {
        return [
            'Fetching request id was failed' => [
                'env' => [],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => VarNotFoundException::class,
            ],
            'CurrentlyNotMergeRequestException' => [
                'env' => [
                    VarName::RefName->value => 'abcd',
                ],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => CurrentlyNotMergeRequestException::class,
                'expectedExceptionPrevious' => null,
            ],
            'Getting graphql url was failed' => [
                'env' => [
                    VarName::RefName->value => '1/merge',
                ],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => VarNotFoundException::class,
            ],
            'Fetching repo information (repository, slug) was failed' => [
                'env' => [
                    VarName::RefName->value => '1/merge',
                    VarName::GraphqlURL->value => 'http://google.com',
                ],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => VarNotFoundException::class,
            ],
            'Merge Request not found' => [
                'env' => [
                    VarName::RefName->value => '1/merge',
                    VarName::GraphqlURL->value => 'http://google.com',
                    VarName::Repository->value => 'artarts36/repo',
                ],
                'clientGetPullRequestResponse' => new \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\NotFoundException(),
                'expectedExceptionClass' => MergeRequestNotFoundException::class,
                'expectedExceptionPrevious' => \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\NotFoundException::class,
            ],
            'Http exceptions' => [
                'env' => [
                    VarName::RefName->value => '1/merge',
                    VarName::GraphqlURL->value => 'http://google.com',
                    VarName::Repository->value => 'artarts36/repo',
                ],
                'clientGetPullRequestResponse' => new ForbiddenException(new Request('GET', 'http://google.com')),
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => ForbiddenException::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::getCurrentlyMergeRequest
     *
     * @dataProvider providerForTestGetCurrentlyMergeRequestOnException
     */
    public function testGetCurrentlyMergeRequestOnException(
        array $env,
        PullRequest|\Throwable|null $clientGetPullRequestResponse,
        string $expectedExceptionClass,
        ?string $expectedPreviousExceptionClass,
    ): void {
        $ci = $this->makeCi($env, new MockGithubClient(getPullRequestResposne: $clientGetPullRequestResponse));

        try {
            $ci->getCurrentlyMergeRequest();
        } catch (\Throwable $e) {
            self::assertInstanceOf($expectedExceptionClass, $e);

            if ($expectedPreviousExceptionClass !== null) {
                self::assertInstanceOf(
                    $expectedPreviousExceptionClass,
                    $e->getPrevious(),
                    $e->getPrevious() !== null ?
                        sprintf('Previous exception is %s with message "%s"', get_class($e->getPrevious()), $e->getMessage()) :
                        'Previous exception didn\'t set',
                );
            }
        }
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::getCurrentlyMergeRequest
     */
    public function testGetCurrentlyMergeRequest(): void
    {
        $client = new MockGithubClient(
            getPullRequestResposne: $pr = new PullRequest(
                '1',
                '2',
                '',
                '',
                [],
                true,
                '',
                '',
                1,
                '',
                false,
                new \DateTimeImmutable(),
                'http://google.com',
            ),
        );

        $ci = $this->makeCi([
            VarName::RefName->value => '1/merge',
            VarName::GraphqlURL->value => 'http://google.com',
            VarName::Repository->value => 'artarts36/repo',
        ], $client);

        $mr = $ci->getCurrentlyMergeRequest();

        self::assertEquals(
            [
                $pr->id,
                $pr->title,
            ],
            [
                $mr->id,
                $mr->title,
            ],
        );
    }

    private function makeCi(array $env, ?GithubClient $githubClient = null): GithubActions
    {
        return new GithubActions(
            new GithubEnvironment(new MapEnvironment(new ArrayMap($env))),
            $githubClient ?? new MockGithubClient(),
        );
    }
}
