<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\QueueClock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MemoryMetricManagerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::register
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::__construct
     */
    public function testRegister(): void
    {
        $manager = new MemoryRegistry();

        self::assertCount(0, $manager->describe());

        $manager->register(CounterVector::once(new MetricSubject('', '', ''), []));

        self::assertCount(1, $manager->describe());
    }

    public function providerForTestDescribe(): array
    {
        return [
            [
                [
                    [$subject1 = new MetricSubject('', 'k', 'n'), $metric1 = new IncCounter()],
                ],
                [
                    new Record($subject1, $metric1, new \DateTimeImmutable()),
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::describe
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::__construct
     * @dataProvider providerForTestDescribe
     */
    public function testDescribe(array $adds, array $expected): void
    {
        $manager = new MemoryRegistry(
            new QueueClock(array_map(fn (Record $record) => $record->date, $expected)),
        );

        foreach ($adds as [$subject, $value]) {
            $manager->add($subject, $value);
        }

        self::assertEquals($expected, $manager->describe()->mapToArray(fn ($item) => $item));
    }
}
