<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Counts;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CountEqualsAnyEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                [],
                [0],
                true,
            ],
            [
                [1],
                [1],
                true,
            ],
            [
                [1],
                [2],
                false,
            ],
            [
                [1],
                [1, 2],
                true,
            ],
            [
                [1],
                [3, 2],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsAnyEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsAnyEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsAnyEvaluator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array $subject, array $evaluatorValue, bool $expected): void
    {
        $evaluator = new CountEqualsAnyEvaluator($evaluatorValue);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($subject)));
    }
}
