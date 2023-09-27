<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

readonly class Duration
{
    public function __construct(
        public float $seconds,
    ) {
    }

    public function __toString(): string
    {
        return "$this->seconds";
    }
}
