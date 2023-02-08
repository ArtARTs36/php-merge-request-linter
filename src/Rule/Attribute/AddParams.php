<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Attribute;

#[\Attribute(
    \Attribute::TARGET_CLASS,
)]
class AddParams
{
    /**
     * @param array<string, Param> $params
     */
    public function __construct(
        public readonly array $params,
    ) {
        //
    }
}
