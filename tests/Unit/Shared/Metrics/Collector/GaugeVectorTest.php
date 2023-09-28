<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Collector;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\GaugeVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GaugeVectorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\GaugeVector::add
     */
    public function testAdd(): void
    {
        $vector = new GaugeVector($subject = new MetricSubject('test', 'collector', ''));

        $createdGaugeFirst = $vector->add();

        self::assertEquals($subject, $createdGaugeFirst->getSubject());
    }
}
