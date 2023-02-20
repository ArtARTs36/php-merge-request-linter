<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NumberTest extends TestCase
{
    public function providerForTestGte(): array
    {
        return [
            '1 = 1' => [1, 1, true],
            '2 > 1' => [2, 1, true],
            '0 > 1' => [0, 1, false],
            '1 = 1 with object' => [1, new Number(1), true],
            '2 > 1 with object' => [2, new Number(1), true],
            '0 > 1 with object' => [0, new Number(1), false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number::gte
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number::__construct
     * @dataProvider providerForTestGte
     */
    public function testGte(int|float $value, Number|int|float $compared, bool $expected): void
    {
        $number = new Number($value);

        self::assertEquals($expected, $number->gte($compared));
    }

    public function providerForTestLte(): array
    {
        return [
            '1 = 1' => [1, 1, true],
            '2 < 1' => [2, 1, false],
            '0 < 1' => [0, 1, true],
            '1 = 1 with object' => [1, new Number(1), true],
            '2 < 1 with object' => [2, new Number(1), false],
            '0 < 1 with object' => [0, new Number(1), true],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number::lte
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number::__construct
     * @dataProvider providerForTestLte
     */
    public function testLte(int|float $value, Number|int|float $compared, bool $expected): void
    {
        $number = new Number($value);

        self::assertEquals($expected, $number->lte($compared));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number::value
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number::__construct
     */
    public function testValue(): void
    {
        $number = new Number($expected = 1);

        self::assertEquals($expected, $number->value());
    }
}
