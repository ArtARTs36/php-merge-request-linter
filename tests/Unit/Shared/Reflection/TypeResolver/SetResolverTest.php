<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\SetResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class SetResolverTest extends TestCase
{
    public function providerForTestCanResolve(): array
    {
        return [
            [
                new Type(TypeName::Object, Set::class),
                [],
                true,
            ],
            [
                new Type(TypeName::Object),
                [],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\SetResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(Type $type, mixed $value, bool $expected): void
    {
        $resolver = new SetResolver();

        self::assertEquals(
            $expected,
            $resolver->canResolve($type, $value),
        );
    }

    public function providerForTestResolve(): array
    {
        return [
            [
                new Type(TypeName::Array),
                ['value1'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\SetResolver::resolve
     * @dataProvider providerForTestResolve
     */
    public function testResolve(Type $type, mixed $value): void
    {
        $resolver = new SetResolver();

        $result = $resolver->resolve($type, $value);

        self::assertInstanceOf(Set::class, $result);
        self::assertEquals($value, $result->values());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\SetResolver::resolve
     */
    public function testResolveOnArgNotSupportedException(): void
    {
        $resolver = new SetResolver();

        self::expectException(ArgNotSupportedException::class);

        $resolver->resolve(new Type(TypeName::Array), 1);
    }
}
