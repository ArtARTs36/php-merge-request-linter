<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Console\Interaction\ProgressBarLintSubscriber;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockProgressBar;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ProgressBarLintSubscriberTest extends TestCase
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
     * @covers \ArtARTs36\MergeRequestLinter\Console\Interaction\ProgressBarLintSubscriber::success
     * @dataProvider providerForTestSuccess
     */
    public function testSuccess(int $runs, int $expectedProgress): void
    {
        $subscriber = $this->makeProgressBarLintSubscriber();

        for ($i = 0; $i < $runs; $i++) {
            $subscriber->subscriber->success('test-rule');
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
     * @covers \ArtARTs36\MergeRequestLinter\Console\Interaction\ProgressBarLintSubscriber::fail
     * @dataProvider providerForTestFail
     */
    public function testFail(int $runs, int $expectedProgress): void
    {
        $subscriber = $this->makeProgressBarLintSubscriber();

        for ($i = 0; $i < $runs; $i++) {
            $subscriber->subscriber->fail('test-rule');
        }

        self::assertEquals($expectedProgress, $subscriber->progressBar->progress);
        self::assertFalse($subscriber->progressBar->finished);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Console\Interaction\ProgressBarLintSubscriber::stopOn
     */
    public function testStopOn(): void
    {
        $subscriber = $this->makeProgressBarLintSubscriber();

        $subscriber->subscriber->stopOn('kuku');

        self::assertTrue($subscriber->progressBar->finished);
    }

    private function makeProgressBarLintSubscriber()
    {
        $bar = new MockProgressBar();
        $subscriber = new ProgressBarLintSubscriber($bar);

        return new class ($bar, $subscriber) {
            public function __construct(
                public MockProgressBar $progressBar,
                public ProgressBarLintSubscriber $subscriber,
            ) {
                //
            }
        };
    }
}
