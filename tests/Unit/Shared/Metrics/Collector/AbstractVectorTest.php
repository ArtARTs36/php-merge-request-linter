<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Collector;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\AbstractVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricType;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Sample;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCollector;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AbstractVectorTest extends TestCase
{
    public static function providerForTestSamples(): array
    {
        return [
            'collectors is empty' => [
                'subCollectors' => [],
                'samples' => [],
            ],
            'collectors with samples' => [
                'subCollectors' => [
                    new Counter(new MetricSubject('', '', '')),
                ],
                'samples' => [
                    new Sample(0, []),
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\AbstractVector::getSamples
     *
     * @dataProvider providerForTestSamples
     */
    public function testGetSamples(array $subCollectors, array $expectedSamples): void
    {
        $vector = new class ($subCollectors) extends AbstractVector {
            public function __construct(array $collectors)
            {
                parent::__construct(new MetricSubject('', '', ''));

                foreach ($collectors as $collector) {
                    $this->attach(fn () => $collector, []);
                }
            }

            public function getMetricType(): MetricType
            {
                return MetricType::Counter;
            }
        };

        self::assertEquals($expectedSamples, $vector->getSamples());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\AbstractVector::attach
     */
    public function testAttachExistsCollector(): void
    {
        $vector = new class(new MetricSubject('', '', '')) extends AbstractVector {
            public function add(array $labels): Collector
            {
                return $this->attach(fn () => new MockCollector(), $labels);
            }

            public function getMetricType(): MetricType
            {
            }
        };

        $collectorOne = $vector->add(['k' => 'v']);
        $collectorTwo = $vector->add(['k' => 'v']);

        self::assertSame(spl_object_hash($collectorOne), spl_object_hash($collectorTwo));
    }
}
