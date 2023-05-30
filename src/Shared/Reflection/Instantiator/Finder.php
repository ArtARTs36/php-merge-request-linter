<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator;

class Finder implements InstantiatorFinder
{
    private const MAKE_METHOD = 'make';

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return Instantiator<T>
     * @throws InstantiatorFindException
     */
    public function find(string $class): Instantiator
    {
        if (! class_exists($class)) {
            throw new InstantiatorFindException(sprintf('Class "%s" not found', $class));
        }

        $reflector = new \ReflectionClass($class);

        if ($reflector->hasMethod(self::MAKE_METHOD)) {
            return new StaticMethodInstantiator($reflector->getMethod(self::MAKE_METHOD), $reflector->getName());
        }

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new EmptyInstantiator($class);
        }

        return new NativeConstructorInstantiator($reflector, $constructor);
    }
}
