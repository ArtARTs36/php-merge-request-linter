<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
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
        $ci = $this->makeCi([]);

        $ci->updateComment(new Comment('', ''));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions::postCommentOnMergeRequest
     */
    public function testPostCommentOnMergeRequest(): void
    {
        $ci = $this->makeCi([]);

        $ci->postCommentOnMergeRequest($this->makeMergeRequest(), 'test');
    }

    private function makeCi(array $env): GithubActions
    {
        return new GithubActions(
            new GithubEnvironment(new MapEnvironment(new ArrayMap($env))),
            new MockGithubClient(),
        );
    }
}
