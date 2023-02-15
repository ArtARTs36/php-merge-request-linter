<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts;

/**
 * Interface for printing table.
 */
interface TablePrinter
{
    /**
     * Print table.
     * @param array<string> $headers
     * @param array<array<int|string>> $rows
     */
    public function printTable(array $headers, array $rows): void;
}
