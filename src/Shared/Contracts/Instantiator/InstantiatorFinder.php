<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Contracts\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Instantiator\InstantiatorFindException;

/**
 * Instantiator Finder for class
 */
interface InstantiatorFinder
{
    /**
     * Find constructor for $class
     * @template T of object
     * @param class-string<T> $class
     * @return Instantiator<T>
     * @throws InstantiatorFindException
     */
    public function find(string $class): Instantiator;
}
