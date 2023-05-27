<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\CompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockArgumentResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CompositeResolverTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\CompositeResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\CompositeResolver::__construct
     */
    public function testResolveOnResolverNotFound(): void
    {
        $resolver = new CompositeResolver([]);

        self::expectException(ArgNotSupportedException::class);

        $resolver->resolve(new Type(TypeName::String), '');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\CompositeResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\CompositeResolver::__construct
     */
    public function testResolveOk(): void
    {
        $resolver = new CompositeResolver([
            TypeName::String->value => new class () implements ArgumentResolver {
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
                    TypeName::String->value => new MockArgumentResolver(false),
                ],
                new Type(TypeName::String),
                null,
                false,
            ],
            [
                [
                    TypeName::String->value => new MockArgumentResolver(true),
                ],
                new Type(TypeName::String),
                null,
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\CompositeResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(array $subResolvers, Type $type, mixed $value, bool $expected): void
    {
        $resolver = new CompositeResolver($subResolvers);

        self::assertEquals(
            $expected,
            $resolver->canResolve($type, $value),
        );
    }
}
