<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Operator\CountMaxOperator;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
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
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\CountMaxOperator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\CountMaxOperator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array|Map $propertyValue, int $max, bool $expected): void
    {
        $operator = new CountMaxOperator(new MockPropertyExtractor($propertyValue), 'prop', $max);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
