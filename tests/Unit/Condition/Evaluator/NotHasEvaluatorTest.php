<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

class NotHasEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [[1, 2], 1, false],
            [[1, 2], 3, true],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array $propertyValue, mixed $value, bool $expected): void
    {
        $operator = new NotHasEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
