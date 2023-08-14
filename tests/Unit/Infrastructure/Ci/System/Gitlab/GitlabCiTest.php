<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\FetchMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\CI\MergeRequestNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\ForbiddenException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\NotFoundException;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockGitlabClient;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class GitlabCiTest extends TestCase
{
    public function providerForTestIs(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['GITLAB_CI' => 'true'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIs
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi::isCurrentlyWorking
     */
    public function testIs(array $env, bool $expected): void
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
                ['CI_MERGE_REQUEST_IID' => 1],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi::isCurrentlyMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi::__construct
     */
    public function testIsMergeRequest(array $env, bool $expected): void
    {
        self::assertEquals($expected, $this->makeCi($env)->isCurrentlyMergeRequest());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi::postCommentOnMergeRequest
     */
    public function testPostCommentOnMergeRequest(): void
    {
        $ci = $this->makeCi([
            'CI_MERGE_REQUEST_IID' => 1,
            'CI_SERVER_URL' => 'https://gitlab.com',
            'CI_MERGE_REQUEST_PROJECT_ID' => 1,
        ]);

        $ci->postCommentOnMergeRequest($this->makeMergeRequest(), 'test-comment');

        $this->addToAssertionCount(1);
    }

    public function providerForTestGetCurrentlyMergeRequestOnException(): array
    {
        return [
            'CurrentlyNotMergeRequestException' => [
                'env' => [],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => CurrentlyNotMergeRequestException::class,
                'expectedExceptionPrevious' => null,
            ],
            'Fetching merge request number was failed' => [
                'env' => [
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::RequestNumber->value => true,
                ],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => VarHasDifferentTypeException::class,
            ],
            'Failed to fetch gitlab server url' => [
                'env' => [
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::RequestNumber->value => 1,
                ],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => VarNotFoundException::class,
            ],
            'Failed to fetch gitlab project id' => [
                'env' => [
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::RequestNumber->value => 1,
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::ApiURL->value => 'http://google.com',
                ],
                'clientGetPullRequestResponse' => null,
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => VarNotFoundException::class,
            ],
            'Merge Request not found' => [
                'env' => [
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::RequestNumber->value => 1,
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::ApiURL->value => 'http://google.com',
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::ProjectID->value => 1,
                ],
                'clientGetPullRequestResponse' => new NotFoundException(new Request('GET', 'http://google.com')),
                'expectedExceptionClass' => MergeRequestNotFoundException::class,
                'expectedExceptionPrevious' => NotFoundException::class,
            ],
            'Other http exceptions' => [
                'env' => [
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::RequestNumber->value => 1,
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::ApiURL->value => 'http://google.com',
                    \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::ProjectID->value => 1,
                ],
                'clientGetPullRequestResponse' => new ForbiddenException(new Request('GET', 'http://google.com')),
                'expectedExceptionClass' => FetchMergeRequestException::class,
                'expectedExceptionPrevious' => ForbiddenException::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi::getCurrentlyMergeRequest
     *
     * @dataProvider providerForTestGetCurrentlyMergeRequestOnException
     */
    public function testGetCurrentlyMergeRequestOnException(
        array $env,
        PullRequest|\Throwable|null $clientGetPullRequestResponse,
        string $expectedExceptionClass,
        ?string $expectedPreviousExceptionClass,
    ): void {
        $ci = $this->makeCi($env, new MockGitlabClient($clientGetPullRequestResponse));

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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi::getCurrentlyMergeRequest
     */
    public function testGetCurrentlyMergeRequest(): void
    {
        $client = new MockGitlabClient(
            $clientMr = new MergeRequest(
                '1',
                '2',
                '3',
                '',
                [],
                false,
                '',
                '',
                '',
                false,
                '',
                [],
                new \DateTimeImmutable(),
                '',
            ),
        );

        $ci = $this->makeCi([
            \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::RequestNumber->value => 1,
            \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::ApiURL->value => 'http://google.com',
            \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\VarName::ProjectID->value => 1,
        ], $client);

        $mr = $ci->getCurrentlyMergeRequest();

        self::assertEquals(
            [
                $clientMr->id,
                $clientMr->title,
            ],
            [
                $mr->id,
                $mr->title,
            ],
        );
    }

    private function makeCi(array $env, ?GitlabClient $client = null): GitlabCi
    {
        return new GitlabCi(
            new GitlabEnvironment($this->makeEnvironment($env)),
            $client ?? new MockGitlabClient(),
            new MockMarkdownCleaner(),
        );
    }
}
