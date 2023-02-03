<?php

namespace ArtARTs36\MergeRequestLinter\Console\Presentation;

class Metric
{
    public function __construct(
        public readonly string $name,
        public readonly string $value,
    ) {
        //
    }
}
