<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSample;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;
use ArtARTs36\Str\Facade\Str;

class Renderer
{
    /**
     * @param iterable<Record> $records
     */
    public function render(iterable $records): string
    {
        $content = [];

        foreach ($records as $metric) {
            if (! isset($metric->samples[0])) {
                continue;
            }

            $content[] = "# HELP {$metric->subject->identity()} The number of items in the queue.";
            $content[] = "# TYPE {$metric->subject->identity()} {$metric->samples[0]->getMetricType()->value}";
            $content[] = "\n";

            foreach ($metric->samples as $sample) {
                $labelsString = $this->collectLabels($sample);

                $content[] = "{$metric->subject->identity()}{$labelsString} {$sample->getMetricValue()}";
            }

            $content[] = "\n";
        }

        return Str::implode("\n", $content);
    }

    private function collectLabels(MetricSample $metric): string
    {
        if (count($metric->getMetricLabels()) === 0) {
            return '';
        }

        $labelsString = '{';
        $labels = $metric->getMetricLabels();

        foreach ($labels as $labelKey => $labelValue) {
            $labelsString .= sprintf(
                '%s=%s',
                $labelKey,
                is_string($labelValue) ? ('"'. $labelValue .'"') : $labelValue,
            );

            if (next($labels) !== false) {
                $labelsString .= ',';
            }
        }

        return $labelsString . '}';
    }
}
