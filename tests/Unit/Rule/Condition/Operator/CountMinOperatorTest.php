<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Rule\Condition\CountMinOperator;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CountMinOperatorTest extends TestCase
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
                false,
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
                false,
            ],
            [
                new Map([1]),
                1,
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\CountMinOperator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\CountMinOperator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array|Map $propertyValue, int $min, bool $expected): void
    {
        $operator = new CountMinOperator(new MockPropertyExtractor($propertyValue), 'prop', $min);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
