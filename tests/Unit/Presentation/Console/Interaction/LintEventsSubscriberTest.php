<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Presentation\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\LintEventsSubscriber;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockProgressBar;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullPrinter;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LintEventsSubscriberTest extends TestCase
{
    public function providerForTestSuccess(): array
    {
        return [
            [
                'runs' => 2,
                'expectedProgress' => 2,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\LintEventsSubscriber::succeed
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\LintEventsSubscriber::__construct
     * @dataProvider providerForTestSuccess
     */
    public function testSuccess(int $runs, int $expectedProgress): void
    {
        $subscriber = $this->makeProgressBarLintSubscriber();

        for ($i = 0; $i < $runs; $i++) {
            $subscriber->subscriber->succeed();
        }

        self::assertEquals($expectedProgress, $subscriber->progressBar->progress);
        self::assertFalse($subscriber->progressBar->finished);
    }

    public function providerForTestFail(): array
    {
        return [
            [
                'runs' => 2,
                'expectedProgress' => 2,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\LintEventsSubscriber::failed
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\LintEventsSubscriber::__construct
     * @dataProvider providerForTestFail
     */
    public function testFail(int $runs, int $expectedProgress): void
    {
        $subscriber = $this->makeProgressBarLintSubscriber();

        for ($i = 0; $i < $runs; $i++) {
            $subscriber->subscriber->failed();
        }

        self::assertEquals($expectedProgress, $subscriber->progressBar->progress);
        self::assertFalse($subscriber->progressBar->finished);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction\LintEventsSubscriber::getSubscribedEvents
     */
    public function testGetSubscribedEvents(): void
    {
        $events = LintEventsSubscriber::getSubscribedEvents();

        $failedEvents = [];

        foreach ($events as $event => $method) {
            if (! class_exists($event) || ! method_exists(LintEventsSubscriber::class, $method)) {
                $failedEvents[$event] = $method;
            }
        }

        self::assertEmpty($failedEvents);
    }

    private function makeProgressBarLintSubscriber()
    {
        $bar = new MockProgressBar();
        $subscriber = new LintEventsSubscriber($bar, new NullPrinter(), false);

        return new class ($bar, $subscriber) {
            public function __construct(
                public MockProgressBar      $progressBar,
                public LintEventsSubscriber $subscriber,
            ) {
                //
            }
        };
    }
}
