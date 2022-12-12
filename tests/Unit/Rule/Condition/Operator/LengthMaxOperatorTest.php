<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Rule\Condition\LengthMaxOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LengthMaxOperatorTest extends TestCase
{
    public function providerForEvaluate(): array
    {
        return [
            [
                'title',
                5,
                true,
            ],
            [
                'title',
                3,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\LengthMaxOperator::evaluate
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(string $propertyValue, int $max, bool $expected): void
    {
        $operator = new LengthMaxOperator(new MockPropertyExtractor($propertyValue), 'prop', $max);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
