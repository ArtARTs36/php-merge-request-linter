<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\CommentProducer;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCommentMessageCreator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullCommenterFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CommentProducerTest extends TestCase
{
    public function providerForTestProduce(): array
    {
        return [
            [
                $this->makeMergeRequest([
                    'id' => 'Test_MR_ID',
                ]),
                null,
                ['[CommentProducer] Comment message for merge request with id "Test_MR_ID" not found'],
            ],
            [
                $this->makeMergeRequest([
                    'id' => 'Test_MR_ID',
                ]),
                'test-comment',
                ['[CommentProducer] Comment for merge request with id "Test_MR_ID" was sent'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\CommentProducer::produce
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\CommentProducer::__construct
     *
     * @dataProvider providerForTestProduce
     */
    public function testProduce(MergeRequest $request, ?string $message, array $expectedLogs): void
    {
        $producer = new CommentProducer(
            new MockCommentMessageCreator($message),
            $logger = $this->mockLogger(),
            new NullCommenterFactory(),
        );

        $logger->expect($expectedLogs);

        $producer->produce($request, $this->makeSuccessLintResult(), new CommentsConfig(
            CommentsPostStrategy::New,
            [],
        ));
    }
}
