<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\EnumResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\TypeName;
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
                new Type(TypeName::String, TestEnum::class),
                '',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\EnumResolver::canResolve
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
                new Type(TypeName::String, TestEnum::class),
                new \stdClass(),
                'Value for enum '. TestEnum::class .' must be int',
            ],
            [
                new Type(TypeName::Int, TestEnum::class),
                4,
                'Enum "'. TestEnum::class .'" not resolved. Available values: [1, 2, 3]',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\EnumResolver::resolve
     * @dataProvider providerForTestResolveOnException
     */
    public function testResolveOnException(Type $type, mixed $value, string $exception): void
    {
        $resolver = new EnumResolver();

        self::expectExceptionMessage($exception);

        $resolver->resolve($type, $value);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\EnumResolver::resolve
     */
    public function testResolve(): void
    {
        $resolver = new EnumResolver();

        self::assertEquals(TestEnum::Val1, $resolver->resolve(
            new Type(TypeName::Int, TestEnum::class),
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
