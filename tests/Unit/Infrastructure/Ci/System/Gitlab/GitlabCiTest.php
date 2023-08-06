<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\CommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\GetCommentsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\Input;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

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

    private function makeCi(array $env): GitlabCi
    {
        return new GitlabCi(
            new GitlabEnvironment($this->makeEnvironment($env)),
            new class () implements GitlabClient {
                public function getMergeRequest(MergeRequestInput $input): MergeRequest
                {
                    // TODO: Implement getMergeRequest() method.
                }

                public function postComment(CommentInput $input): void
                {
                    // TODO: Implement postComment() method.
                }

                public function getCurrentUser(Input $input): User
                {
                    // TODO: Implement getCurrentUser() method.
                }

                public function getCommentsOnMergeRequest(GetCommentsInput $input): Arrayee
                {
                    // TODO: Implement getCommentsOnMergeRequest() method.
                }

                public function updateComment(UpdateCommentInput $input): void
                {
                    // TODO: Implement updateComment() method.
                }
            },
            new MockMarkdownCleaner(),
        );
    }
}
