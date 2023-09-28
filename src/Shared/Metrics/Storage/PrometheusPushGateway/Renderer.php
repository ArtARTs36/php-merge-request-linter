<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Sample;
use ArtARTs36\Str\Facade\Str;

class Renderer
{
    /**
     * @param iterable<Collector> $collectors
     */
    public function render(iterable $collectors): string
    {
        $content = [];

        foreach ($collectors as $collector) {
            $samples = $collector->getSamples();

            if (count($samples) === 0) {
                continue;
            }

            $key = $collector->getSubject()->identity();

            $content[] = "# HELP $key The number of items in the queue.";
            $content[] = "# TYPE $key {$collector->getMetricType()->value}";
            $content[] = "\n";

            foreach ($samples as $sample) {
                $labelsString = $this->collectLabels($sample);

                $content[] = "$key$labelsString $sample->value";
            }

            $content[] = "\n";
        }

        return Str::implode("\n", $content);
    }

    private function collectLabels(Sample $metric): string
    {
        if (count($metric->labels) === 0) {
            return '';
        }

        $labelsString = '{';
        $labels = $metric->labels;

        foreach ($labels as $labelKey => $labelValue) {
            $labelsString .= sprintf(
                '%s=%s',
                $labelKey,
                is_numeric($labelValue) ? $labelValue : ('"'. $labelValue .'"'),
            );

            if (next($labels) !== false) {
                $labelsString .= ',';
            }
        }

        return $labelsString . '}';
    }
}
