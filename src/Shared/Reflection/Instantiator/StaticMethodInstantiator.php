<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Reflector;

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
        return Reflector::mapParamNameOnParam($this->constructor);
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
