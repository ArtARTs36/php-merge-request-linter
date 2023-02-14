<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\GteEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GteEvaluatorTest extends TestCase
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\GteEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\GteEvaluator::evaluate
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(int|float $propertyValue, int|float $value, bool $expected): void
    {
        $operator = new GteEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
