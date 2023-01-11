<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support\DataStructure;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Traits\ContainsAll;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainsAllTest extends TestCase
{
    public function providerForTestContainsAll(): array
    {
        return [
            [
                [1, 2, 3, 4, 5],
                [2, 4],
                true,
            ],
            [
                [1, 2, 3, 4, 5],
                [6, 4],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestContainsAll
     */
    public function testContainsAll(array $collection, array $values, bool $expected): void
    {
        self::assertEquals($expected, (new CollectionForContainsAllTest($collection))->containsAll($values));
    }
}

class CollectionForContainsAllTest
{
    use ContainsAll;

    public function __construct(
        private array $items,
    ) {
        //
    }
}
