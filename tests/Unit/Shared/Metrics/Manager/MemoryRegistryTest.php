<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Gauge;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\CollectorAlreadyRegisteredException;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MemoryRegistryTest extends TestCase
{
    public function providerForTestDescribe(): array
    {
        return [
            [
                [],
                [],
            ],
            [
                [
                    $counter1 = new Counter(new MetricSubject('test', 'counter', '')),
                ],
                [
                    'test_counter' => $counter1,
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::register
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::describe
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::__construct
     * @dataProvider providerForTestDescribe
     */
    public function testDescribe(array $adds, array $expected): void
    {
        $manager = new MemoryRegistry();

        foreach ($adds as $collector) {
            $manager->register($collector);
        }

        self::assertEquals($expected, $manager->describe()->toArray());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::register
     */
    public function testRegisterOnAlreadyRegistered(): void
    {
        $registry = new MemoryRegistry();

        $registry->register(new Counter(new MetricSubject('test', 'collector', '')));

        self::expectException(CollectorAlreadyRegisteredException::class);

        $registry->register(new Gauge(new MetricSubject('test', 'collector', '')));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::getOrRegister
     */
    public function testGetOrRegister(): void
    {
        $registry = new MemoryRegistry();

        $registry->getOrRegister($first = new Counter(new MetricSubject('test', 'collector', '')));

        $got = $registry->getOrRegister(new Counter(new MetricSubject('test', 'collector', '')));

        self::assertEquals($first, $got);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry::getOrRegister
     */
    public function testGetOrRegisterOnAlreadyRegisteredWithDifferentType(): void
    {
        $registry = new MemoryRegistry();

        $registry->getOrRegister(new Counter(new MetricSubject('test', 'collector', '')));

        self::expectExceptionMessage('Already registered collector "test_collector" with type "ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter". Expected type: ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Gauge');

        $registry->getOrRegister(new Gauge(new MetricSubject('test', 'collector', '')));
    }
}
