<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Operator\LteOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LteOperatorTest extends TestCase
{
    public function providerForEvaluate(): array
    {
        return [
            [1, 2, true],
            [2, 2, true],
            [3, 2, false],
            [1.5, 2.5, true],
            [2.5, 2.5, true],
            [3.5, 2.5, false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\LteOperator::doEvaluate
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(int|float $propertyValue, int|float $lte, bool $expected): void
    {
        $operator = new LteOperator(new MockPropertyExtractor($propertyValue), 'prop', $lte);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
