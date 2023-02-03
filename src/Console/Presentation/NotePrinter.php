<?php

namespace ArtARTs36\MergeRequestLinter\Console\Presentation;

use ArtARTs36\MergeRequestLinter\Contracts\IO\TablePrinter;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;
use ArtARTs36\MergeRequestLinter\Note\Notes;
use ArtARTs36\MergeRequestLinter\Note\NoteSeverity;
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
