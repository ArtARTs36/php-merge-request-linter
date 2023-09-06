<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Attributes;

/**
 * @codeCoverageIgnore
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
class Generic
{
    public const OF_STRING = 'string';
    public const OF_INTEGER = 'integer';

    public function __construct(
        public string $type,
    ) {
    }
}
