<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Operator\ContainsOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainsOperatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            ['aabbaa', 'bb', true],
            ['aababaa', 'bb', false],
            [1234, '12', true],
            [1234, '11', false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\ContainsOperator::evaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(mixed $propertyValue, mixed $contains, bool $expected): void
    {
        $operator = new ContainsOperator(new MockPropertyExtractor($propertyValue), 'prop', $contains);

        self::assertEquals($expected, $operator->evaluate($this->makeMergeRequest()));
    }
}
