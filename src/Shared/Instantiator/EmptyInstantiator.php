<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\Instantiator\Instantiator;

/**
 * @template T of object
 * @template-implements Instantiator<T>
 */
final class EmptyInstantiator implements Instantiator
{
    /**
     * @param class-string<T> $class
     */
    public function __construct(
        private readonly string $class,
    ) {
        //
    }

    public function params(): array
    {
        return [];
    }

    /**
     * @return T
     */
    public function instantiate(array $args): object
    {
        $class = $this->class;

        return new $class();
    }
}
