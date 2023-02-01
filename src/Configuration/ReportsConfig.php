<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

class ReportsConfig
{
    public function __construct(
        public readonly ReporterConfig $reporter,
    ) {
        //
    }
}
