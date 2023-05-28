<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ValueInvalidException;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayeeResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrayeeResolverTest extends TestCase
{
    public function providerForTestCanResolve(): array
    {
        return [
            [
                new Type(TypeName::Object, Arrayee::class),
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
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayeeResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(Type $type, mixed $value, bool $expected): void
    {
        $resolver = new ArrayeeResolver();

        self::assertEquals(
            $expected,
            $resolver->canResolve($type, $value),
        );
    }

    public function providerForTestResolve(): array
    {
        return [
            [new Type(TypeName::Array), ['val1']],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayeeResolver::resolve
     * @dataProvider providerForTestResolve
     */
    public function testResolve(Type $type, mixed $value): void
    {
        $resolver = new ArrayeeResolver();

        $result = $resolver->resolve($type, $value);

        self::assertInstanceOf(Arrayee::class, $result);
        self::assertEquals($value, $result->mapToArray(fn ($val) => $val));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayeeResolver::resolve
     */
    public function testResolveOnArgNotSupported(): void
    {
        $resolver = new ArrayeeResolver();

        self::expectException(ValueInvalidException::class);

        $resolver->resolve(new Type(TypeName::Array), 'string');
    }
}
