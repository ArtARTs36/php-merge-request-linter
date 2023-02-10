<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterType;
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

    public function resolve(ParameterType $type, mixed $value): mixed
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
