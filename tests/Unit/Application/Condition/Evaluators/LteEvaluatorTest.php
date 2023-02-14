<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LteEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LteEvaluatorTest extends TestCase
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LteEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LteEvaluator::doEvaluate
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(int|float $propertyValue, int|float $value, bool $expected): void
    {
        $operator = new LteEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
