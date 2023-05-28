<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

final class ContainerResolver implements ArgumentResolver
{
    public const NAME = 'container';

    public function __construct(
        private readonly ContainerInterface $container,
    ) {
        //
    }

    public function canResolve(Type $type, mixed $value): bool
    {
        return $type->class !== null && $this->container->has($type->class);
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        $class = $type->class;

        if ($class === null || ! class_exists($class) && ! interface_exists($class)) {
            throw new ArgNotSupportedException(sprintf(
                'Type with name "%s" not supported',
                $type->name->value,
            ));
        }

        if (! $this->container->has($class)) {
            throw new ArgNotSupportedException(sprintf(
                'Resolver for type "%s" not found',
                $type->class,
            ));
        }

        try {
            return $this->container->get($class);
        } catch (ContainerExceptionInterface $e) {
            throw new ArgNotSupportedException(sprintf(
                'Type "%s" didn\'t resolved: %s',
                $type->class,
                $e->getMessage(),
            ), previous: $e);
        }
    }
}
