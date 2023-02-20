<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Metrics;

use ArtARTs36\MergeRequestLinter\Domain\Metrics\Metric;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\Record;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RecordTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Metrics\Record::getValue
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Metrics\Record::__construct
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
