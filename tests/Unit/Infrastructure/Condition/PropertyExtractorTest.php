<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\CallbackPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class PropertyExtractorTest extends TestCase
{
    public function providerForTestInterface(): array
    {
        return [
            ['test', Str::class],
            [1.0, Number::class],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\CallbackPropertyExtractor::interface
     * @dataProvider providerForTestInterface
     */
    public function testInterface(string|int|float $rawValue, string $interface): void
    {
        $obj = new class ($rawValue) {
            public function __construct(
                private mixed $prop
            ) {
                //
            }
        };

        $extractor = new CallbackPropertyExtractor();

        self::assertInstanceOf($interface, $extractor->interface($obj, 'prop', $interface));
    }
}
