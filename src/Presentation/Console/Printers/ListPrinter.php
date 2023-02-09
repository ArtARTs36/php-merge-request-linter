<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Printers;

use Symfony\Component\Console\Output\OutputInterface;

class ListPrinter
{
    /**
     * @param array<string|callable(): string> $lines
     */
    public function print(OutputInterface $output, array $lines): void
    {
        foreach ($lines as $line) {
            $line = is_callable($line) ? $line() : $line;

            $output->write('- '. $line);
            $output->write("\n");
        }
    }
}
