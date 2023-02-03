<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\IO;

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
