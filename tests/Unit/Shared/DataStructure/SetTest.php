<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class SetTest extends TestCase
{
    public function providerTestImplode(): array
    {
        return [
            [
                ['Hello', 'mr.', 'Artem!'],
                ' ',
                'Hello mr. Artem!',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::implode
     * @dataProvider providerTestImplode
     */
    public function testImplode(array $set, string $separator, string $expected): void
    {
        $ds = Set::fromList($set);

        self::assertEquals($expected, $ds->implode($separator));
    }

    public function providerForTestFirst(): array
    {
        return [
            [
                [1, 2],
                1,
            ],
            [
                [],
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::first
     * @dataProvider providerForTestFirst
     */
    public function testFirst(array $set, mixed $expected): void
    {
        self::assertEquals($expected, Set::fromList($set)->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::values
     */
    public function testValues(): void
    {
        $set = Set::fromList($values = ['value1', 'value2']);

        self::assertEquals($values, $set->values());
    }
}
