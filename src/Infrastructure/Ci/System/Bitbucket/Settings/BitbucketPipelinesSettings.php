<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings;

/**
 * @codeCoverageIgnore
 */
class BitbucketPipelinesSettings
{
    public function __construct(
        public readonly LabelsSettings $labels,
    ) {
        //
    }
}
