<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings;

/**
 * @codeCoverageIgnore
 */
class LabelsOfDescriptionSettings
{
    /**
     * @param non-empty-string $lineStartsWith
     * @param non-empty-string $separator
     */
    public function __construct(
        public readonly string $lineStartsWith,
        public readonly string $separator,
    ) {
        //
    }
}
