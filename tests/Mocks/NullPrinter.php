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

    public function printInfoLine(string $message): void
    {
        //
    }

    public function line(int $count): void
    {
        // TODO: Implement line() method.
    }
}
