<?php

namespace ArtARTs36\MergeRequestLinter\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
class Generic
{
    public const OF_STRING = 'string';

    public function __construct(
        public string $type,
    ) {
        //
    }
}
