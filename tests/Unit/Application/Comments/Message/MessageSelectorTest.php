<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageSelector;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockOperatorResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MessageSelectorTest extends TestCase
{
    public function providerForTestSelect(): array
    {
        return [
            'empty comments' => [
                null,
                'comments' => [],
                null,
            ],
            'comment without conditions' => [
                null,
                'comments' => [
                    new CommentsMessage('1', []),
                    new CommentsMessage('2', []),
                ],
                new CommentsMessage('1', []),
            ],
            'comment with condition: ok' => [
                MockConditionOperator::true(),
                'comments' => [
                    new CommentsMessage('1', [
                        'condition' => 'test',
                    ]),
                    new CommentsMessage('2', []),
                ],
                new CommentsMessage('1', [
                    'condition' => 'test',
                ]),
            ],
            'comment with failed conditions' => [
                MockConditionOperator::false(),
                'comments' => [
                    new CommentsMessage('1', [
                        'condition' => 'test',
                    ]),
                    new CommentsMessage('2', [
                        'condition' => 'test',
                    ]),
                ],
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageSelector::select
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageSelector::__construct
     *
     * @dataProvider providerForTestSelect
     *
     * @param array<CommentsMessage> $commentsMessages
     */
    public function testSelect(?ConditionOperator $conditionOperator, array $commentsMessages, ?CommentsMessage $expectedCommentMessage): void
    {
        $selector = new MessageSelector(new MockOperatorResolver($conditionOperator));

        self::assertEquals(
            $expectedCommentMessage,
            $selector->select(
                $this->makeMergeRequest(),
                new CommentsConfig(
                    CommentsPostStrategy::Null,
                    $commentsMessages,
                ),
                LintResult::fail(new LintNote(''), new Duration(1))
            ),
        );
    }
}
