<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\GenericResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GenericResolverTest extends TestCase
{
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\GenericResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\GenericResolver::__construct
     * @dataProvider providerForTestResolve
     */
    public function testResolve(Type $type, mixed $value, mixed $expected): void
    {
        $resolver = new GenericResolver(new AsIsResolver());

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
