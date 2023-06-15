<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments\Listener;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommentProducer;
use ArtARTs36\MergeRequestLinter\Application\Comments\Listener\LintFinishedListener;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintState;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullCommentProducer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class LintFinishedListenerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Listener\LintFinishedListener::call
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Listener\LintFinishedListener::__construct
     */
    public function testCallEventNotSupported(): void
    {
        $listener = new LintFinishedListener(new NullCommentProducer(), new CommentsConfig(CommentsPostStrategy::Null, []));

        self::expectException(\LogicException::class);

        $listener->call(new \stdClass());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Listener\LintFinishedListener::call
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Listener\LintFinishedListener::__construct
     */
    public function testCall(): void
    {
        $commenter = $this->createMock(CommentProducer::class);
        $commenter
            ->expects(new InvokedCount(1))
            ->method('produce');

        $listener = new LintFinishedListener($commenter, new CommentsConfig(CommentsPostStrategy::Null, []));

        $listener->call(new LintFinishedEvent($this->makeMergeRequest(), new LintResult(
            LintState::Success,
            new Arrayee([]),
            new Duration(1),
        )));
    }
}
