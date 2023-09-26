<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway;

class Renderer
{
    /**
     * @param iterable<Metric> $records
     */
    public function render(iterable $records): string
    {
        $content = '';

        foreach ($records as $metric) {
            $value = $metric->value;

            $labelsString = $this->collectLabels($metric);

            $content .= <<<HTML
# HELP {$metric->key} The number of items in the queue.
# TYPE {$metric->key} {$metric->type}

{$metric->key}{$labelsString} $value

HTML;
        }

        return $content;
    }

    private function collectLabels(Metric $metric): string
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
                is_string($labelValue) ? ('"'. $labelValue .'"') : $labelValue,
            );

            if (next($labels) !== false) {
                $labelsString .= ',';
            }
        }

        return $labelsString . '}';
    }
}
