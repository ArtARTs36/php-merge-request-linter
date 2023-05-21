<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\Instantiator\Instantiator;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Reflector;

/**
 * @template T of object
 * @template-implements Instantiator<T>
 */
class StaticMethodInstantiator implements Instantiator
{
    /**
     * @param class-string<T> $class
     */
    public function __construct(
        private readonly \ReflectionMethod $constructor,
        private readonly string $class,
    ) {
        //
    }

    public function params(): array
    {
        return Reflector::mapMethodParamTypeOnParam($this->constructor);
    }

    /**
     * @return T
     */
    public function instantiate(array $args): object
    {
        return ($this->createCallback())(...$args);
    }

    /**
     * @return callable(mixed...): T
     */
    private function createCallback(): callable
    {
        $class = $this->class;
        $method = $this->constructor->getName();

        /** @var callable(mixed...): T $callback */
        $callback = $class::$method(...);

        return $callback;
    }
}
