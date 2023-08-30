<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings;

/**
 * @codeCoverageIgnore
 */
readonly class BitbucketPipelinesSettings
{
    public function __construct(
        public LabelsSettings $labels,
    ) {
        //
    }
}
