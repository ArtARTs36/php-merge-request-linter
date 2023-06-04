<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
class Example
{
    public function __construct(
        public mixed $value,
    ) {
        //
    }
}
