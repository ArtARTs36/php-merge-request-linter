<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\MapResolver;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

class MapResolverTest extends TestCase
{
    public function providerForTestResolve(): array
    {
        return [
            [
                [1, 2],
                new Map([
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
    public function testResolve(mixed $value, Map $expected): void
    {
        $resolver = new MapResolver();

        $resolvedValue = $resolver->resolve($value);

        self::assertInstanceOf(Map::class, $resolvedValue);
        self::assertTrue($expected->equals($resolvedValue));
    }
}
