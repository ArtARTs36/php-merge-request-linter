<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\GenericResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GenericResolverTest extends TestCase
{
    public function providerForTestCanResolve(): array
    {
        return [
            [
                new Type(TypeName::Object, generic: TestObject::class),
                [],
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\GenericResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(Type $type, mixed $value, bool $expected): void
    {
        $resolver = new GenericResolver($asIsResolver = new AsIsResolver(), new ArrayObjectConverter($asIsResolver));

        self::assertEquals(
            $expected,
            $resolver->canResolve($type, $value),
        );
    }

    public function providerForTestResolve(): array
    {
        return [
            [
                new Type(TypeName::Bool),
                true,
                true,
            ],
            [
                new Type(TypeName::Object, generic: TestObject::class),
                [
                    [
                        'name' => 'Dev',
                    ],
                ],
                [
                    new TestObject('Dev'),
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\GenericResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\GenericResolver::__construct
     * @dataProvider providerForTestResolve
     */
    public function testResolve(Type $type, mixed $value, mixed $expected): void
    {
        $resolver = new GenericResolver($asIsResolver = new AsIsResolver(), new ArrayObjectConverter($asIsResolver));

        self::assertEquals($expected, $resolver->resolve($type, $value));
    }
}

class TestObject
{
    public function __construct(
        public readonly string $name,
    ) {
        //
    }

    public function equals(TestObject $object): bool
    {
        return $this->name === $object->name;
    }
}
