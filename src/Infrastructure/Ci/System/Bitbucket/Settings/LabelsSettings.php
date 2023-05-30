<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings;

/**
 * @codeCoverageIgnore
 */
class LabelsSettings
{
    public function __construct(
        public readonly ?LabelsOfDescriptionSettings $ofDescription,
    ) {
        //
    }
}
