<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class PropertyNotExists extends MergeRequestLinterException
{
    public static function make(string $property): self
    {
        return new self(sprintf('Property "%s" not exists', $property));
    }
}
