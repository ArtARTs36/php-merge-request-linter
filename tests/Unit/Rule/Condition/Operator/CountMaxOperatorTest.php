<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Rule\Condition\CountMaxOperator;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CountMaxOperatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                [],
                0,
                true,
            ],
            [
                [1],
                10,
                true,
            ],
            [
                [1],
                1,
                true,
            ],
            [
                new Map([]),
                0,
                true,
            ],
            [
                new Map([1]),
                10,
                true,
            ],
            [
                new Map([1]),
                1,
                true,
            ],
        ];
    }

    /**
     * @covers CountMaxOperator::evaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array|Map $propertyValue, int $max, bool $expected): void
    {
        $operator = new CountMaxOperator(new MockPropertyExtractor($propertyValue), 'prop', $max);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
