<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Factories;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\ConditionRuleFactory;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockOperatorResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConditionRuleFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\ConditionRuleFactory::new
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\ConditionRuleFactory::__construct
     */
    public function testNew(): void
    {
        ConditionRuleFactory::new(
            new MockOperatorResolver(),
            $metrics = new MemoryMetricManager(LocalClock::utc()),
        );

        self::assertCount(1, $metrics->describe());
    }
}
