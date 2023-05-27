<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Attributes;

/**
 * @codeCoverageIgnore
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
class Description
{
    public function __construct(
        public readonly string $description,
    ) {
        //
    }
}
