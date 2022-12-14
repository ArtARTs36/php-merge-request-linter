<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Rule\Condition\GteOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GteOperatorTest extends TestCase
{
    public function providerForEvaluate(): array
    {
        return [
            [1, 2, false],
            [2, 2, true],
            [3, 2, true],
            [1.5, 2.5, false],
            [2.5, 2.5, true],
            [3.5, 2.5, true],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\GteOperator::doEvaluate
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(int|float $propertyValue, int|float $lte, bool $expected): void
    {
        $operator = new GteOperator(new MockPropertyExtractor($propertyValue), 'prop', $lte);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
