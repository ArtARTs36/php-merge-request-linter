<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings;

class LabelsSettings
{
    public function __construct(
        public readonly ?LabelsOfDescriptionSettings $ofDescription,
    ) {
        //
    }
}
