<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Printers;

readonly class Metric
{
    public function __construct(
        public string $name,
        public string $value,
    ) {
        //
    }
}
