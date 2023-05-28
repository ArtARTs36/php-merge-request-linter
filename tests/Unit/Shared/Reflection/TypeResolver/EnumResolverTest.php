<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\EnumResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EnumResolverTest extends TestCase
{
    public function providerForTestCanResolve(): array
    {
        return [
            [
                new Type(TypeName::String),
                '',
                false,
            ],
            [
                new Type(TypeName::String, 'class'),
                '',
                false,
            ],
            [
                new Type(TypeName::String, \ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers\TestEnum::class),
                '',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\EnumResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(Type $type, mixed $value, bool $expected): void
    {
        $resolver = new EnumResolver();

        self::assertEquals($expected, $resolver->canResolve($type, $value));
    }

    public function providerForTestResolveOnException(): array
    {
        return [
            [
                new Type(TypeName::String),
                '',
                'Type with name "string" not supported',
            ],
            [
                new Type(TypeName::String, 'non-enum'),
                '',
                'Type with name "non-enum" not supported',
            ],
            [
                new Type(TypeName::String, \ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers\TestEnum::class),
                new \stdClass(),
                'Value for enum '. \ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers\TestEnum::class .' must be int',
            ],
            [
                new Type(TypeName::Int, \ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers\TestEnum::class),
                4,
                'Enum "'. \ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers\TestEnum::class .'" not resolved. Available values: [1, 2, 3]',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\EnumResolver::resolve
     * @dataProvider providerForTestResolveOnException
     */
    public function testResolveOnException(Type $type, mixed $value, string $exception): void
    {
        $resolver = new EnumResolver();

        self::expectExceptionMessage($exception);

        $resolver->resolve($type, $value);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\EnumResolver::resolve
     */
    public function testResolve(): void
    {
        $resolver = new EnumResolver();

        self::assertEquals(\ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers\TestEnum::Val1, $resolver->resolve(
            new Type(TypeName::Int, \ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers\TestEnum::class),
            1,
        ));
    }
}

enum TestEnum: int
{
    case Val1 = 1;
    case Val2 = 2;
    case Val3 = 3;
}
