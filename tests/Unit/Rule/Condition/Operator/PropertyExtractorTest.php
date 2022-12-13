<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Support\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class PropertyExtractorTest extends TestCase
{
    public function providerForNumeric(): array
    {
        return [
            ['1', 1],
            ['1.0', 1.0],
            [1, 1],
            [1.0, 1.0],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\PropertyExtractor::numeric
     * @dataProvider providerForNumeric
     */
    public function testNumeric(string|int|float $rawValue, int|float $expected): void
    {
        $obj = new class ($rawValue) {
            public function __construct(
                private mixed $prop
            ) {
                //
            }
        };

        $extractor = new PropertyExtractor();

        self::assertTrue($expected === $extractor->numeric($obj, 'prop'));
    }
}
