<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageCreator;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockMessageRenderer;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockMessageSelector;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MessageCreatorTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            'message not selected' => [
                null,
                '',
                null,
            ],
            'message selected' => [
                new CommentsMessage('', []),
                'test-message',
                'test-message',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageCreator::__construct
     *
     * @dataProvider providerForTestCreate
     */
    public function testCreate(?CommentsMessage $selectedMessage, string $renderedMessage, ?string $expectedMessage): void
    {
        $creator = new MessageCreator(
            new MockMessageSelector($selectedMessage),
            new MockMessageRenderer($renderedMessage),
        );

        self::assertEquals(
            $expectedMessage,
            $creator->create(
                $this->makeMergeRequest(),
                $this->makeSuccessLintResult(),
                new CommentsConfig(
                    CommentsPostStrategy::Null,
                    [],
                ),
            )
        );
    }
}
