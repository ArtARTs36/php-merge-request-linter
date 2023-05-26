<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ConditionListener;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\Listener;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockOperatorResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConditionListenerTest extends TestCase
{
    public function providerForTestHandle(): array
    {
        return [
            [
                MockConditionOperator::false(),
                0,
            ],
            [
                MockConditionOperator::true(),
                1,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ConditionListener::handle
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ConditionListener::__construct
     * @dataProvider providerForTestHandle
     */
    public function testHandle(ConditionOperator $operator, int $expectedCalls): void
    {
        $listener = new ConditionListener(
            new NotificationEventMessage('', new Channel(ChannelType::TelegramBot, new ArrayMap([]), TimePeriod::day()), '', []),
            new MockOperatorResolver($operator),
            $counter = new CallsCounterListener(),
        );

        $listener->handle(new \stdClass());

        self::assertEquals($expectedCalls, $counter->calls);
    }
}

final class CallsCounterListener implements Listener
{
    public int $calls = 0;

    public function handle(object $event): void
    {
        $this->calls++;
    }
}
