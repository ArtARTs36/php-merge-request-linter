<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Printers;

use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Note\Notes;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\TablePrinter;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;

class NotePrinter
{
    private const HEADERS = ['#', 'Note'];

    public function print(TablePrinter $printer, Notes $notes): void
    {
        $table = [];

        $tableCellOptions = [
            NoteSeverity::Fatal->value => [
                'style' => new TableCellStyle([
                    'fg' => 'red',
                ]),
            ],
            NoteSeverity::Normal->value => [],
        ];

        $counter = 0;

        /** @var Note $note */
        foreach ($notes as $note) {
            ++$counter;

            $table[] = [
                new TableCell("$counter", $tableCellOptions[$note->getSeverity()->value]),
                new TableCell($note->getDescription(), $tableCellOptions[$note->getSeverity()->value]),
            ];
        }

        $printer->printTable(self::HEADERS, $table);
    }
}
