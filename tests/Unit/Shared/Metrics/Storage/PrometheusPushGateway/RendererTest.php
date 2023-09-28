<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Storage\PrometheusPushGateway;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Renderer;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCollector;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RendererTest extends TestCase
{
    public static function providerForTestRender(): array
    {
        return [
            [
                'collectors' => [],
                'expectedContent' => '',
            ],
            [
                'collectors' => [
                    new MockCollector(),
                ],
                'expectedContent' => '',
            ],
            [
                'collectors' => [
                    new Counter(new MetricSubject('test', 'collector', 'Super title'), [], 2),
                ],
                'expectedContent' => "# HELP test_collector Super title
# TYPE test_collector Counter
\n
test_collector 2\n\n",
            ],
            [
                'collectors' => [
                    new Counter(new MetricSubject('test', 'collector', 'Super title'), ['label1' => 'value1'], 2),
                ],
                'expectedContent' => "# HELP test_collector Super title
# TYPE test_collector Counter
\n
test_collector{label1=\"value1\"} 2\n\n",
            ],
            [
                'collectors' => [
                    new Counter(new MetricSubject('test', 'collector', 'Super title'), ['label1' => 'value1', 'label2' => 'value2'], 2),
                ],
                'expectedContent' => "# HELP test_collector Super title
# TYPE test_collector Counter
\n
test_collector{label1=\"value1\",label2=\"value2\"} 2\n\n",
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Renderer::render
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Renderer::collectLabels
     *
     * @dataProvider providerForTestRender
     */
    public function testRender(array $collectors, string $expectedContent): void
    {
        $renderer = new Renderer();

        self::assertEquals($expectedContent, $renderer->render($collectors));
    }
}
