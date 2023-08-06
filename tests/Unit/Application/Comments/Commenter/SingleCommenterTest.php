<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\SingleCommenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\MakingComment;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\NewUpdatingMessageFormatter;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class SingleCommenterTest extends TestCase
{
    public function providerForTestPostComment(): array
    {
        return [
            'create new comment' => [
                'PR_ID',
                [
                    '[SingleCommenter] Fetching first comment for MR with id "PR_ID" by current user',
                    '[SingleCommenter] First comment by current user not found',
                    '[SingleCommenter] Creating comment for MR with id "PR_ID"',
                    '[SingleCommenter] Comment for MR with id "PR_ID" was created',
                ],
                new MakingComment('test-comment'),
                null,
            ],
            'update comment: no update because text identical' => [
                'PR_ID',
                [
                    '[SingleCommenter] Fetching first comment for MR with id "PR_ID" by current user',
                    '[SingleCommenter] Updating comment with id "test-comment-id" for MR with id "PR_ID"',
                    '[SingleCommenter] Updating comment with id "test-comment-id" for MR with id "PR_ID" was skipped: messages identical',
                ],
                new MakingComment('test-comment'),
                new Comment('test-comment-id', 'test-comment'),
            ],
            'update comment: ok' => [
                'PR_ID',
                [
                    '[SingleCommenter] Fetching first comment for MR with id "PR_ID" by current user',
                    '[SingleCommenter] Updating comment with id "test-comment-id" for MR with id "PR_ID"',
                    '[SingleCommenter] Comment #test-comment-id for MR #PR_ID was updated',
                ],
                new MakingComment('test-comment'),
                new Comment('test-comment-id', 'test-comment-2'),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\SingleCommenter::postComment
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\SingleCommenter::createComment
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\SingleCommenter::updateCommentIfHaveNewMessage
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\SingleCommenter::updateComment
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\SingleCommenter::__construct
     *
     * @dataProvider providerForTestPostComment
     */
    public function testPostComment(string $requestId, array $expectedLogs, MakingComment $makingComment, ?Comment $firstComment): void
    {
        $ci = $this->createMock(CiSystem::class);
        $ci
            ->expects(new InvokedCount(1))
            ->method('getFirstCommentOnMergeRequestByCurrentUser')
            ->willReturn($firstComment);

        $commenter = new SingleCommenter(
            $ci,
            $logger = $this->mockLogger(),
            new NewUpdatingMessageFormatter(),
        );

        $logger->expect($expectedLogs);

        $commenter->postComment($this->makeMergeRequest([
            'id' => $requestId,
        ]), $makingComment);
    }
}
