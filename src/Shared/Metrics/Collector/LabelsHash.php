<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

class LabelsHash
{
    /**
     * @param array<string, string> $labels
     */
    public static function hash(array $labels): string
    {
        $hash = '';

        foreach ($labels as $key => $value) {
            $hash .= $key . '-' . $value;
        }

        return $hash;
    }
}
