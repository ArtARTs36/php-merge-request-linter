<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Attributes;

/**
 * @codeCoverageIgnore
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
readonly class Description
{
    public function __construct(
        public string $description,
    ) {
        //
    }
}
