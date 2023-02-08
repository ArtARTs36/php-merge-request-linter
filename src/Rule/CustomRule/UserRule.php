<?php

namespace ArtARTs36\MergeRequestLinter\Rule\CustomRule;

class UserRule
{
    public function __construct(
        public readonly string $property,
        public readonly array $conditions,
    ) {
        //
    }
}
