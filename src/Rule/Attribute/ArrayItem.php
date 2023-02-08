<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Attribute;

class ArrayItem implements Param
{
    public function __construct(
        private readonly ?string $ref,
    ) {
        //
    }

    public function ref(): ?string
    {
        return $this->ref;
    }
}
