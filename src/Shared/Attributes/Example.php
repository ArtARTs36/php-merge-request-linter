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

    public function __toString(): string
    {
        if (is_bool($this->value)) {
            return $this->value ? 'true' : 'false';
        }

        if (is_numeric($this->value)) {
            return (string) $this->value;
        }

        return '"'. $this->value . '"';
    }
}
