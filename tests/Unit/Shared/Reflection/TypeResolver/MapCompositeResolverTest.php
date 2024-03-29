<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\TypeResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapCompositeResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ValueInvalidException;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockTypeResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MapCompositeResolverTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapCompositeResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapCompositeResolver::__construct
     */
    public function testResolveOnResolverNotFound(): void
    {
        $resolver = new MapCompositeResolver([]);

        self::expectException(ValueInvalidException::class);

        $resolver->resolve(new Type(TypeName::String), '');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapCompositeResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapCompositeResolver::__construct
     */
    public function testResolveOk(): void
    {
        $resolver = new MapCompositeResolver([
            TypeName::String->value => new class () implements TypeResolver {
                public function canResolve(Type $type, mixed $value): bool
                {
                    return true;
                }

                public function resolve(Type $type, mixed $value): mixed
                {
                    return 'test-value';
                }
            },
        ]);

        self::assertEquals('test-value', $resolver->resolve(new Type(TypeName::String), ''));
    }

    public function providerForTestCanResolve(): array
    {
        return [
            [
                [],
                new Type(TypeName::String),
                null,
                false,
            ],
            [
                [
                    TypeName::String->value => new MockTypeResolver(false),
                ],
                new Type(TypeName::String),
                null,
                false,
            ],
            [
                [
                    TypeName::String->value => new MockTypeResolver(true),
                ],
                new Type(TypeName::String),
                null,
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapCompositeResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(array $subResolvers, Type $type, mixed $value, bool $expected): void
    {
        $resolver = new MapCompositeResolver($subResolvers);

        self::assertEquals(
            $expected,
            $resolver->canResolve($type, $value),
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapCompositeResolver::add
     */
    public function testAdd(): void
    {
        $resolver = new MapCompositeResolver();

        $type = new Type(TypeName::String);

        self::assertFalse($resolver->canResolve($type, null));

        $resolver->add('string', new AsIsResolver());

        self::assertTrue($resolver->canResolve($type, null));
    }
}
