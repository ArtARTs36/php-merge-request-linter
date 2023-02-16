<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ArrayeeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrayeeResolverTest extends TestCase
{
    public function providerForTestResolve(): array
    {
        return [
            [new Type(TypeName::Array), ['val1']],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ArrayeeResolver::resolve
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\ArrayeeResolver::resolve
     */
    public function testResolveOnArgNotSupported(): void
    {
        $resolver = new ArrayeeResolver();

        self::expectException(ArgNotSupportedException::class);

        $resolver->resolve(new Type(TypeName::Array), 'string');
    }
}
