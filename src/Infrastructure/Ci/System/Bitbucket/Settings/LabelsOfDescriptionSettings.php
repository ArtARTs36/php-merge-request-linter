<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings;

/**
 * @codeCoverageIgnore
 */
readonly class LabelsOfDescriptionSettings
{
    /**
     * @param non-empty-string $lineStartsWith
     * @param non-empty-string $separator
     */
    public function __construct(
        public string $lineStartsWith,
        public string $separator,
    ) {
        //
    }
}
