<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Collector;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\AbstractCollector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricType;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Sample;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AbstractCollectorTest extends TestCase
{
    public static function providerForTestGetFirstSampleValue(): array
    {
        return [
            'empty samples' => [
                'existsSamples' => [],
                'expectedValue' => null,
            ],
            'returns first sample value from array with length 1' => [
                'existsSamples' => [
                    new Sample('val', []),
                ],
                'expectedValue' => 'val',
            ],
            'returns first sample value from array with length 2' => [
                'existsSamples' => [
                    new Sample('val', []),
                    new Sample('val2', []),
                ],
                'expectedValue' => 'val',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\AbstractCollector::getFirstSampleValue
     *
     * @dataProvider providerForTestGetFirstSampleValue
     */
    public function testGetFirstSampleValue(array $existsSamples, int|float|string|null $expectedValue): void
    {
        $collector = new class ($existsSamples) extends AbstractCollector {
            public function __construct(private array $samples)
            {
                parent::__construct(new MetricSubject('', '', ''));
            }

            public function getSamples(): array
            {
                return $this->samples;
            }

            public function getMetricType(): MetricType
            {
            }
        };

        self::assertEquals($expectedValue, $collector->getFirstSampleValue());
    }
}
