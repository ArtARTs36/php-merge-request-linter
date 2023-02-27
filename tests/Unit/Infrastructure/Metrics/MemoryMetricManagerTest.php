<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Metrics;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\QueueClock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MemoryMetricManagerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager::add
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager::__construct
     */
    public function testAdd(): void
    {
        $manager = new MemoryMetricManager();

        self::assertCount(0, $manager->describe());

        $manager->add(new MetricSubject('', ''), new IncCounter());

        self::assertCount(1, $manager->describe());
    }

    public function providerForTestDescribe(): array
    {
        return [
            [
                [
                    [$subject1 = new MetricSubject('k', 'n'), $metric1 = new IncCounter()],
                ],
                [
                    new Record($subject1, $metric1, new \DateTimeImmutable()),
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager::describe
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager::__construct
     * @dataProvider providerForTestDescribe
     */
    public function testDescribe(array $adds, array $expected): void
    {
        $manager = new MemoryMetricManager(
            new QueueClock(array_map(fn (Record $record) => $record->date, $expected)),
        );

        foreach ($adds as [$subject, $value]) {
            $manager->add($subject, $value);
        }

        self::assertEquals($expected, $manager->describe()->mapToArray(fn ($item) => $item));
    }
}
