<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\Reflector;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ObjectCompositeResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ValueInvalidException;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockTypeResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ObjectCompositeResolverTest extends TestCase
{
    public static function providerForTestCanResolve(): array
    {
        return [
            [
                'subResolvers' => [],
                'type' => new Type(TypeName::Object),
                'value' => null,
                'expectedResult' => false,
            ],
            [
                'subResolvers' => [
                    new MockTypeResolver(false),
                ],
                'type' => new Type(TypeName::Object),
                'value' => null,
                'expectedResult' => false,
            ],
            [
                'subResolvers' => [
                    new MockTypeResolver(false),
                    new MockTypeResolver(true),
                ],
                'type' => new Type(TypeName::Object),
                'value' => null,
                'expectedResult' => true,
            ],
            [
                'subResolvers' => [
                    new MockTypeResolver(true),
                ],
                'type' => new Type(TypeName::Object),
                'value' => null,
                'expectedResult' => true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ObjectCompositeResolver::canResolve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ObjectCompositeResolver::__construct
     *
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(array $subResolvers, Type $type, mixed $value, bool $expectedResult): void
    {
        $resolver = new ObjectCompositeResolver($subResolvers);

        self::assertEquals($expectedResult, $resolver->canResolve($type, $value));
    }

    public static function providerForTestResolve(): array
    {
        return [
            [
                'subResolvers' => [
                    new MockTypeResolver(false),
                    new MockTypeResolver(true, $rv = new \stdClass()),
                ],
                'type' => new Type(TypeName::Object),
                'value' => '',
                'expectedResult' => $rv,
            ],
            [
                'subResolvers' => [
                    new MockTypeResolver(true, $rv = new \stdClass()),
                ],
                'type' => new Type(TypeName::Object),
                'value' => '',
                'expectedResult' => $rv,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ObjectCompositeResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ObjectCompositeResolver::__construct
     *
     * @dataProvider providerForTestResolve
     */
    public function testResolve(array $subResolvers, Type $type, mixed $value, mixed $expectedResult): void
    {
        $resolver = new ObjectCompositeResolver($subResolvers);

        self::assertEquals($expectedResult, $resolver->resolve($type, $value));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ObjectCompositeResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ObjectCompositeResolver::__construct
     */
    public function testResolveOnValueInvalidException(): void
    {
        $resolver = new ObjectCompositeResolver([]);

        self::expectException(ValueInvalidException::class);

        $resolver->resolve(new Type(TypeName::Object), '');
    }
}
