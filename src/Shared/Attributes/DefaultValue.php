<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Attributes;

/**
 * @codeCoverageIgnore
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
readonly class DefaultValue
{
    public function __construct(
        public mixed $value,
    ) {
    }
}