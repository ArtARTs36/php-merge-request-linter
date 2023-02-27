<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Metrics;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Metric;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RecordTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record::getValue
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record::__construct
     */
    public function testGetValue(): void
    {
        $record = new Record(
            new MetricSubject('', ''),
            new class () implements Metric {
                public function getMetricValue(): string
                {
                    return 'test-metric-value';
                }
            },
            new \DateTime(),
        );

        self::assertEquals('test-metric-value', $record->getValue());
    }
}
