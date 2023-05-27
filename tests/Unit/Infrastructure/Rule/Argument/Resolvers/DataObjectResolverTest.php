<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\DataObjectResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DataObjectResolverTest extends TestCase
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
                new Type(TypeName::String),
                [],
                false,
            ],
            [
                new Type(TypeName::Object, self::class),
                '',
                false,
            ],
            [
                new Type(TypeName::Object, self::class),
                [],
                true,
            ],
            [
                new Type(TypeName::Object, self::class),
                null,
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\DataObjectResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(Type $type, mixed $value, bool $expected): void
    {
        $resolver = new DataObjectResolver(new ArrayObjectConverter());

        self::assertEquals($expected, $resolver->canResolve($type, $value));
    }

    public function providerForTestResolveOnException(): array
    {
        return [
            [
                new Type(TypeName::Object),
                null,
                'Type with name "object" not supported',
            ],
            [
                new Type(TypeName::Object, 'not-exists-class'),
                null,
                'Type with name "not-exists-class" not supported',
            ],
            [
                new Type(TypeName::Object, self::class),
                1,
                sprintf(
                    'Value for type with name "%s" must be array or null, given %s',
                    self::class,
                    'integer',
                ),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\DataObjectResolver::resolve
     * @dataProvider providerForTestResolveOnException
     */
    public function testResolveOnException(Type $type, mixed $value, string $expected): void
    {
        $resolver = new DataObjectResolver(new ArrayObjectConverter());

        self::expectExceptionMessage($expected);

        $resolver->resolve($type, $value);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\DataObjectResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\DataObjectResolver::__construct
     */
    public function testResolve(): void
    {
        $resolver = new DataObjectResolver(new ArrayObjectConverter());

        $result = $resolver->resolve(new Type(TypeName::Object, TestDataObject::class), [
            'name' => '12',
        ]);

        self::assertInstanceOf(TestDataObject::class, $result);
        self::assertEquals('12', $result->name);
    }
}

class TestDataObject
{
    public function __construct(
        public readonly string $name,
    ) {
        //
    }
}
