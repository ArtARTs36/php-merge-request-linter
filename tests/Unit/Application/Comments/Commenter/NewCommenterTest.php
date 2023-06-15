<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\NewCommenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\MakingComment;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NewCommenterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\NewCommenter::postComment
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\NewCommenter::doPostComment
     */
    public function testPostComment(): void
    {
        $commenter = new NewCommenter(
            new MockCi(),
            $logger = $this->mockLogger(),
        );

        $mergeRequest = $this->makeMergeRequest([
            'id' => 'PR_M',
        ]);

        $logger->expect([
            '[NewCommenter] sending comment on merge request with id "PR_M" through CI "mock_ci"',
            '[NewCommenter] comment on merge request with id "PR_M" was sent',
        ]);

        $commenter
            ->postComment($mergeRequest, new MakingComment('test-comment'));
    }
}
