<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\IO;

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
