<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Conditions\Operators;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\CallbackPropertyExtractor;
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\CallbackPropertyExtractor::numeric
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

        $extractor = new CallbackPropertyExtractor();

        self::assertTrue($expected === $extractor->numeric($obj, 'prop'));
    }
}
