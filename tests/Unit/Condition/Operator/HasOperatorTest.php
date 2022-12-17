<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Operator\HasOperator;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasOperatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [[1, 2], 1, true],
            [[1, 2], 3, false],
            [Set::fromList([1, 2]), 1, true],
            [Set::fromList([1, 2]), 3, false],
            [new Map([1, 2]), 1, true],
            [new Map([1, 2]), 3, false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\HasOperator::evaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array|Set|Map $propertyValue, mixed $includes, bool $expected): void
    {
        $operator = new HasOperator(new MockPropertyExtractor($propertyValue), 'prop', $includes);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
