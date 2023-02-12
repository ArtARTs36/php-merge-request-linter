<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

class Duration
{
    public function __construct(
        public readonly float $seconds,
    ) {
        //
    }

    public function __toString(): string
    {
        return "$this->seconds" . 's';
    }
}
