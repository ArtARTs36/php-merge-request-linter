<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings;

/**
 * @phpstan-type OfDescription = array{line_starts_with: string, separator: string}
 */
class LabelsSettings
{
    /**
     * @param OfDescription|null $ofDescription
     */
    public function __construct(
        public readonly ?array $ofDescription,
    ) {
        //
    }
}
