<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\Reflector;

/**
 * @template T of object
 * @template-implements Instantiator<T>
 */
final class NativeConstructorInstantiator implements Instantiator
{
    /**
     * @param \ReflectionClass<T> $classReflector
     */
    public function __construct(
        private readonly \ReflectionClass  $classReflector,
        private readonly \ReflectionMethod $constructorReflector,
    ) {
        //
    }

    public function params(): array
    {
        return Reflector::mapParamNameOnParam($this->constructorReflector);
    }

    /**
     * @return T
     */
    public function instantiate(array $args): object
    {
        /** @var class-string<T> $class */
        $class = $this->classReflector->getName();

        return new $class(...$args);
    }
}
