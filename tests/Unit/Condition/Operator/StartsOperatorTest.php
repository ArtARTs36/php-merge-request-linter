<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Operator\StartsOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class StartsOperatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            ['abcd', 'ab', true],
            ['abcd', 'ac', false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Operator\StartsOperator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(mixed $propertyValue, string $starts, bool $expected): void
    {
        $operator = new StartsOperator(new MockPropertyExtractor($propertyValue), 'prop', $starts);

        self::assertTrue($expected === $operator->evaluate($this->makeMergeRequest([])));
    }
}
