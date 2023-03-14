<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;
use ArtARTs36\Str\Str;

/**
 * @phpstan-import-type OfDescription from LabelsSettings
 */
class DescriptionLabelsResolver implements LabelsResolver
{
    public function resolve(PullRequest $pr, LabelsSettings $settings): array
    {
        $params = $settings->ofDescription;

        if ($params === null) {
            return [];
        }

        $prefix = $params['line_starts_with'];

        /** @var Str $line */
        foreach ($pr->description->lines() as $line) {
            if ($line->startsWith($prefix)) {
                return $this->findLabels($line, $params);
            }
        }

        return [];
    }

    /**
     * @param OfDescription $settings
     * @return array<string>
     */
    private function findLabels(Str $line, array $settings): array
    {
        return $line
            ->deleteWhenStarts($settings['line_starts_with'])
            ->explode($settings['separator'])
            ->trim()
            ->toStrings();
    }
}
