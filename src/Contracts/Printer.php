<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * IO Printer.
 */
interface Printer
{
    /**
     * Print object.
     */
    public function printObject(object $object): void;
}
