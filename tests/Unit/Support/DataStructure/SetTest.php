<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support\DataStructure;

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
}
