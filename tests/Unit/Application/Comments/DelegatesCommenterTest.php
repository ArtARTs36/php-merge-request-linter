<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\CommenterFactory;
use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\Factory;
use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\DelegatesCommenter;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintState;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullCommenterFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DelegatesCommenterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\DelegatesCommenter::postComment
     */
    public function testPostComment(): void
    {
        $commenter = new DelegatesCommenter(
            $logger = $this->mockLogger(),
            $this->createCommenterFactory(),
        );

        $logger->expect([
            '[DelegatesCommenter] Sending comment on merge request "test-mr"',
            '[DelegatesCommenter] Comment on merge request "test-mr" was sent',
        ]);

        $commenter->postComment(
            $this->makeMergeRequest([
                'title' => 'test-mr',
            ]),
            new LintResult(LintState::Success, new Arrayee([]), new Duration(0)),
            new CommentsConfig(
                CommentsPostStrategy::Null,
                [],
            ),
        );
    }

    private function createCommenterFactory(): CommenterFactory
    {
        return new NullCommenterFactory();
    }
}
