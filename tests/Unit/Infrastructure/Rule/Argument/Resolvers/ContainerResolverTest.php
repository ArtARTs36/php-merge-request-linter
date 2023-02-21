<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ContainerResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\TypeName;
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ContainerResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ContainerResolver::__construct
     * @dataProvider providerForTestResolveOnExceptions
     */
    public function testResolveOnExceptions(Type $paramType, array $container, string $expectException): void
    {
        self::expectExceptionMessage($expectException);

        $resolver = new ContainerResolver(new MockContainer(...$container));
        $resolver->resolve($paramType, null);
    }
}
