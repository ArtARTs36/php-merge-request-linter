<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ContainerResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainerResolverTest extends TestCase
{
    public function providerForTestResolveOnExceptions(): array
    {
        return [
            [new Type(TypeName::String), [], 'Type with name "string" not supported'],
            [new Type(TypeName::Object, \stdClass::class), [], 'Resolver for type "stdClass" not found'],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ContainerResolver::resolve
     * @dataProvider providerForTestResolveOnExceptions
     */
    public function testResolveOnExceptions(Type $paramType, array $container, string $expectException): void
    {
        self::expectExceptionMessage($expectException);

        $resolver = new ContainerResolver(new MapContainer($container));
        $resolver->resolve($paramType, null);
    }
}
