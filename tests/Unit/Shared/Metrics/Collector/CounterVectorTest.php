<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Collector;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CounterVectorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector::add
     */
    public function testAdd(): void
    {
        $vector = new CounterVector($subject = new MetricSubject('test', 'collector', ''));

        $createdCounter = $vector->add(['k' => 'v']);

        self::assertEquals($subject, $createdCounter->getSubject());
    }
}
