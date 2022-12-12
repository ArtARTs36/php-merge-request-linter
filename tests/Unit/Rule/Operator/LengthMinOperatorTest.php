<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Operator;

use ArtARTs36\MergeRequestLinter\Rule\Condition\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LengthMinOperatorTest extends TestCase
{
    public function providerForEvaluate(): array
    {
        return [
            [
                'title',
                3,
                true,
            ],
            [
                'title',
                10,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\LengthMinOperator::evaluate
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(string $propertyValue, int $min, bool $expected): void
    {
        $operator = new LengthMinOperator(new MockPropertyExtractor($propertyValue), 'prop', $min);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
