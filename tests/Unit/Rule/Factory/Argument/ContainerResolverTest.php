<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\ContainerResolver;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterType;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterTypeName;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainerResolverTest extends TestCase
{
    public function providerForTestResolveOnExceptions(): array
    {
        return [
            [new ParameterType(ParameterTypeName::String), [], 'Type with name "string" not supported'],
            [new ParameterType(ParameterTypeName::Object, \stdClass::class), [], 'Resolver for type "stdClass" not found'],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\ContainerResolver::resolve
     * @dataProvider providerForTestResolveOnExceptions
     */
    public function testResolveOnExceptions(ParameterType $paramType, array $container, string $expectException): void
    {
        self::expectExceptionMessage($expectException);

        $resolver = new ContainerResolver(new MapContainer($container));
        $resolver->resolve($paramType, null);
    }
}
