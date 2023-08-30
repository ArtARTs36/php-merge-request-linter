<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings;

/**
 * @codeCoverageIgnore
 */
readonly class LabelsSettings
{
    public function __construct(
        public ?LabelsOfDescriptionSettings $ofDescription,
    ) {
        //
    }
}
