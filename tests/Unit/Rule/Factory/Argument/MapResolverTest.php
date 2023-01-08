<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Exception\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\MapResolver;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

class MapResolverTest extends TestCase
{
    public function providerForTestResolve(): array
    {
        return [
            [
                [
                    1 => 1,
                    2 => 2,
                ],
                new ArrayMap([
                    1 => 1,
                    2 => 2,
                ]),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\MapResolver::resolve
     * @dataProvider providerForTestResolve
     */
    public function testResolve(mixed $value, ArrayMap $expected): void
    {
        $resolver = new MapResolver();

        $resolvedValue = $resolver->resolve($value);

        self::assertInstanceOf(ArrayMap::class, $resolvedValue);
        self::assertTrue($expected->equals($resolvedValue));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\MapResolver::resolve
     */
    public function testResolveOnArgNotSupportedException(): void
    {
        $resolver = new MapResolver();

        self::expectException(ArgNotSupportedException::class);

        $resolver->resolve(1);
    }
}
