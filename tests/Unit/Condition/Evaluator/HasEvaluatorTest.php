<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Condition\Evaluator\HasEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [[1, 2], 1, true],
            [[1, 2], 3, false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Evaluator\HasEvaluator::evaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array $propertyValue, mixed $value, bool $expected): void
    {
        $operator = new HasEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
