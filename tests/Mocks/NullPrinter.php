<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\Printer;

class NullPrinter implements Printer
{
    public function printObject(object $object): void
    {
        //
    }
}
