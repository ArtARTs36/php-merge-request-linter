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
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::fromList
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
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::fromList
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::hash
     * @dataProvider providerForTestFirst
     */
    public function testFirst(array $set, mixed $expected): void
    {
        self::assertEquals($expected, Set::fromList($set)->first());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::values
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::fromList
     */
    public function testValues(): void
    {
        $set = Set::fromList($values = ['value1', 'value2']);

        self::assertEquals($values, $set->values());
    }

    public function providerForTestContains(): array
    {
        return [
            [
                [1, 2, 3],
                1,
                true,
            ],
            [
                [1, 2, 3],
                4,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::contains
     * @dataProvider providerForTestContains
     */
    public function testContains(array $set, mixed $value, bool $expected): void
    {
        $set = Set::fromList($set);

        self::assertEquals($expected, $set->contains($value));
    }

    public function providerForTestContainsAll(): array
    {
        return [
            [
                [1, 2, 3],
                [1, 2],
                true,
            ],
            [
                [1, 2, 3],
                [1, 4],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set::containsAll
     * @dataProvider providerForTestContainsAll
     */
    public function testContainsAll(array $items, array $values, bool $expected): void
    {
        $set = Set::fromList($items);

        self::assertEquals($expected, $set->containsAll($values));
    }
}
