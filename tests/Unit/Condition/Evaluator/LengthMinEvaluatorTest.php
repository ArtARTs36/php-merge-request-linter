<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LengthMinEvaluatorTest extends TestCase
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LengthMinOperator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LengthMinOperator::doEvaluateF
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(string $propertyValue, int $value, bool $expected): void
    {
        $operator = new LengthMinOperator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
