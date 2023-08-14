<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\MergeRequestNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\CommentList;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\VarName;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\CompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\BitbucketPipelinesSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\ForbiddenException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\NotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\BitbucketPR;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockBitbucketClient;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockClient;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockLogger;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class BitbucketPipelinesTest extends TestCase
{
    public function providerForTestIsCurrentlyWorking(): array
    {
        return [
            [
                [
                    VarName::ProjectKey->value => 'super-project',
                ],
                true,
            ],
            [
                [],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::isCurrentlyWorking
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::__construct
     * @dataProvider providerForTestIsCurrentlyWorking
     */
    public function testIsCurrentlyWorking(array $vars, bool $expected): void
    {
        $ci = $this->createCi($vars);

        self::assertEquals($expected, $ci->isCurrentlyWorking());
    }

    public function providerForTestIsCurrentlyMergeRequest(): array
    {
        return [
            [
                [
                    VarName::PullRequestId->value => 1,
                ],
                true,
            ],
            [
                [],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::isCurrentlyMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::__construct
     * @dataProvider providerForTestIsCurrentlyMergeRequest
     */
    public function testIsCurrentlyMergeRequest(array $vars, bool $expected): void
    {
        $ci = $this->createCi($vars);

        self::assertEquals($expected, $ci->isCurrentlyMergeRequest());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::postCommentOnMergeRequest()
     */
    public function testPostCommentOnMergeRequest(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->expects(new InvokedCount(1))
            ->method('postComment')
            ->willReturn(new Comment(1, 'https://site.ru', 'test-comment', '1234'));

        $ci = $this->createCi([
            VarName::Workspace->value => 'owner',
            VarName::RepoName->value => 'repo',
            VarName::PullRequestId->value => 1,
        ], $client, $logger = new MockLogger());

        $ci->postCommentOnMergeRequest($this->makeMergeRequest(), 'test-comment');

        $logger->assertPushedInfo('[BitbucketPipelines] Comment was created with id 1 and url https://site.ru');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::updateComment()
     */
    public function testUpdateComment(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->expects(new InvokedCount(1))
            ->method('updateComment')
            ->willReturn(new Comment('1', '', '', ''));

        $ci = $this->createCi(
            [
                VarName::Workspace->value => 'owner',
                VarName::RepoName->value => 'repo',
                VarName::PullRequestId->value => 1,
            ],
            $client,
            $logger = new MockLogger(),
        );

        $ci->updateComment(new \ArtARTs36\MergeRequestLinter\Domain\Request\Comment(
            '1',
            'test-comment',
        ));

        $logger->assertPushedInfo('[BitbucketPipelines] Comment with id "1" was updated');
    }

    public function providerForTestGetFirstCommentOnMergeRequestByCurrentUser(): array
    {
        return [
            [
                new User('test', '4'),
                [
                    new CommentList(new Arrayee([
                        new Comment('1', '', 'test1', '2'),
                        new Comment('2', '', 'test2', '1'),
                        new Comment('3', '', 'test3', '1'),
                        new Comment('4', '', 'test4', '3'),
                    ]), 1),
                    new CommentList(new Arrayee([]), 2),
                ],
                null,
            ],
            [
                new User('test', '1'),
                [
                    new CommentList(new Arrayee([
                        new Comment('1', '', 'test1', '2'),
                        new Comment('2', '', 'test2', '1'), // expected comment
                        new Comment('3', '', 'test3', '1'),
                        new Comment('4', '', 'test4', '3'),
                    ]), 1),
                ],
                new \ArtARTs36\MergeRequestLinter\Domain\Request\Comment('2', 'test2'),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::getFirstCommentOnMergeRequestByCurrentUser()
     *
     * @dataProvider providerForTestGetFirstCommentOnMergeRequestByCurrentUser
     *
     * @param array<CommentList> $responseCommentLists
     */
    public function testGetFirstCommentOnMergeRequestByCurrentUser(
        User        $user,
        array $responseCommentLists,
        ?\ArtARTs36\MergeRequestLinter\Domain\Request\Comment    $expectedComment,
    ): void {
        $client = $this->createMock(Client::class);
        $client
            ->expects(new InvokedCount(1))
            ->method('getCurrentUser')
            ->willReturn($user);

        $client
            ->expects(new InvokedCount(count($responseCommentLists)))
            ->method('getComments')
            ->willReturn(...$responseCommentLists);

        $ci = $this->createCi(
            [
                VarName::Workspace->value => 'owner',
                VarName::RepoName->value => 'repo',
                VarName::PullRequestId->value => 1,
            ],
            $client,
        );

        self::assertEquals(
            $expectedComment,
            $ci->getFirstCommentOnMergeRequestByCurrentUser($this->makeMergeRequest()),
        );
    }

    public function providerForTestGetCurrentlyMergeRequestOnException(): array
    {
        return [
            'Fetching repo information (repository, slug) was failed' => [
                'env' => [],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => VarNotFoundException::class,
            ],
            'CurrentlyNotMergeRequestException' => [
                'env' => [
                    VarName::Workspace->value => 'owner',
                    VarName::RepoName->value => 'repo',
                ],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => CurrentlyNotMergeRequestException::class,
                'expectedExceptionPrevious' => VarNotFoundException::class,
            ],
            'Pull Request not found' => [
                'env' => [
                    VarName::Workspace->value => 'owner',
                    VarName::RepoName->value => 'repo',
                    VarName::PullRequestId->value => '1',
                ],
                'clientGetPullRequestResponse' => new NotFoundException(new Request('GET', 'http://google.com'), new Response()),
                'expectedExceptionClass' => MergeRequestNotFoundException::class,
                'expectedExceptionPrevious' => NotFoundException::class,
            ],
            'Other http exceptions' => [
                'env' => [
                    VarName::Workspace->value => 'owner',
                    VarName::RepoName->value => 'repo',
                    VarName::PullRequestId->value => '1',
                ],
                'clientGetPullRequestResponse' => new ForbiddenException(new Request('GET', 'http://google.com')),
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => ForbiddenException::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::getCurrentlyMergeRequest
     *
     * @dataProvider providerForTestGetCurrentlyMergeRequestOnException
     */
    public function testGetCurrentlyMergeRequestOnException(
        array $env,
        PullRequest|\Throwable|null $clientGetPullRequestResponse,
        string $expectedExceptionClass,
        ?string $expectedPreviousExceptionClass,
    ): void {
        $ci = $this->createCi($env, new MockBitbucketClient(getPullRequest: $clientGetPullRequestResponse));

        try {
            $ci->getCurrentlyMergeRequest();
        } catch (\Throwable $e) {
            self::assertInstanceOf($expectedExceptionClass, $e);
            self::assertInstanceOf(
                $expectedPreviousExceptionClass,
                $e->getPrevious(),
                sprintf('Previous exception is %s with message "%s"', get_class($e->getPrevious()), $e->getMessage()),
            );
        }
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines::getCurrentlyMergeRequest
     */
    public function testGetCurrentlyMergeRequest(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->expects(new InvokedCount(1))
            ->method('getPullRequest')
            ->willReturn($pr = BitbucketPR::create());

        $ci = $this->createCi([
            VarName::Workspace->value => 'owner',
            VarName::RepoName->value => 'repo',
            VarName::PullRequestId->value => '1',
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

    /**
     * @param array<string, mixed> $env
     */
    private function createCi(array $env, ?Client $client = null, ?LoggerInterface $logger = null): BitbucketPipelines
    {
        return new BitbucketPipelines(
            $client ?? new HttpClient(
                new NullAuthenticator(),
                new MockClient(),
                new NullLogger(),
                new NativeJsonProcessor(),
                new PullRequestSchema(LocalClock::utc()),
            ),
            new BitbucketEnvironment(new MapEnvironment(
                new ArrayMap($env),
            )),
            new MockMarkdownCleaner(),
            new BitbucketPipelinesSettings(new LabelsSettings(null)),
            new CompositeResolver([]),
            $logger ?? new NullLogger(),
        );
    }
}
