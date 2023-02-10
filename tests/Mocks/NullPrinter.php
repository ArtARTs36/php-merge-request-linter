<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\Printer;

class NullPrinter implements Printer
{
    public function printTitle(string $title): void
    {
        //
    }

    public function printObject(object $object): void
    {
        //
    }
}
