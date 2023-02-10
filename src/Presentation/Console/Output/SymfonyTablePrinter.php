<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Output;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\TablePrinter;
use Symfony\Component\Console\Style\StyleInterface;

class SymfonyTablePrinter implements TablePrinter
{
    public function __construct(
        private readonly StyleInterface $output,
    ) {
        //
    }

    public function printTable(array $headers, array $rows): void
    {
        $this->output->table($headers, $rows);
    }
}
