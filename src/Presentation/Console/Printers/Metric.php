<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Printers;

class Metric
{
    public function __construct(
        public readonly string $name,
        public readonly string $value,
    ) {
        //
    }
}
