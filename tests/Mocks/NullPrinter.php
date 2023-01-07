<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\IO\Printer;

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
