<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Rule\Condition\IncludesOperator;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class IncludesOperatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [[1, 2], 1, true],
            [[1, 2], 3, false],
            [Map::fromList([1, 2]), 1, true],
            [Map::fromList([1, 2]), 3, false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Rule\Condition\IncludesOperator::evaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array|Map $propertyValue, mixed $includes, bool $expected): void
    {
        $operator = new IncludesOperator(new MockPropertyExtractor($propertyValue), 'prop', $includes);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
