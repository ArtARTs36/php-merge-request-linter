<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts;

/**
 * IO Printer.
 */
interface Printer
{
    /**
     * Print title.
     */
    public function printTitle(string $title): void;

    /**
     * Print object.
     */
    public function printObject(object $object): void;
}
