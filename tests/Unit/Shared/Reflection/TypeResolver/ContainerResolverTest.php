<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ContainerResolver;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockContainer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainerResolverTest extends TestCase
{
    public function providerForTestResolveOnExceptions(): array
    {
        return [
            [new Type(TypeName::String), [], 'Type with name "string" not supported'],
            [new Type(TypeName::Object, \stdClass::class), [], 'Resolver for type "stdClass" not found'],
            [new Type(TypeName::Object, \stdClass::class), ['get' => null, 'has' => true], 'Type "stdClass" didn\'t resolved: Object of class "stdClass" not found'],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ContainerResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ContainerResolver::__construct
     * @dataProvider providerForTestResolveOnExceptions
     */
    public function testResolveOnExceptions(Type $paramType, array $container, string $expectException): void
    {
        self::expectExceptionMessage($expectException);

        $resolver = new ContainerResolver(new MockContainer(...$container));
        $resolver->resolve($paramType, null);
    }

    public function providerForTestCanResolve(): array
    {
        return [
            [
                false,
                new Type(TypeName::Object),
                '',
                false,
            ],
            [
                false,
                new Type(TypeName::Object, \stdClass::class),
                '',
                false,
            ],
            [
                true,
                new Type(TypeName::Object, \stdClass::class),
                '',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ContainerResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(bool $containerHas, Type $type, mixed $value, bool $expected): void
    {
        $resolver = new ContainerResolver(
            new MockContainer(
                null,
                $containerHas,
            ),
        );

        self::assertEquals($expected, $resolver->canResolve($type, $value));
    }
}
