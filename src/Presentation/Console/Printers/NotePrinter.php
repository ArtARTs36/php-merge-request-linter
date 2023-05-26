<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Printers;

use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\TablePrinter;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\Str\Facade\Str;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;

class NotePrinter
{
    private const HEADERS = ['#', 'Severity', 'Note'];

    /**
     * @param Arrayee<int, Note> $notes
     */
    public function print(TablePrinter $printer, Arrayee $notes): void
    {
        $table = [];

        $tableCellOptions = [
            NoteSeverity::Fatal->value => [
                'style' => new TableCellStyle([
                    'fg' => 'red',
                ]),
            ],
            NoteSeverity::Warning->value => [
                'style' => new TableCellStyle([
                    'fg' => 'yellow',
                ]),
            ],
            NoteSeverity::Error->value => [],
        ];

        $counter = 0;

        /** @var Note $note */
        foreach ($notes as $note) {
            ++$counter;

            $cellOptions = $tableCellOptions[$note->getSeverity()->value];

            $table[] = [
                new TableCell("$counter", $cellOptions),
                new TableCell(Str::upFirstSymbol($note->getSeverity()->value), $cellOptions),
                new TableCell($note->getDescription(), $cellOptions),
            ];
        }

        $printer->printTable(self::HEADERS, $table);
    }
}
