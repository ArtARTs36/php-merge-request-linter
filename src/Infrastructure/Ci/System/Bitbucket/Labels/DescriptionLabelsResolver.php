<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsOfDescriptionSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;
use ArtARTs36\Str\Str;

class DescriptionLabelsResolver implements LabelsResolver
{
    public function resolve(PullRequest $pr, LabelsSettings $settings): array
    {
        $params = $settings->ofDescription;

        if ($params === null) {
            return [];
        }

        $prefix = $params->lineStartsWith;

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
    private function findLabels(Str $line, LabelsOfDescriptionSettings $settings): array
    {
        return $line
            ->deleteWhenStarts($settings->lineStartsWith)
            ->explode($settings->separator)
            ->trim()
            ->toStrings();
    }
}
