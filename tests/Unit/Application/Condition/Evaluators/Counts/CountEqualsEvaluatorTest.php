<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Counts;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CountEqualsEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                [],
                0,
                true,
            ],
            [
                [1],
                1,
                true,
            ],
            [
                [1],
                2,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array $subject, int $evaluatorValue, bool $expected): void
    {
        $evaluator = new CountEqualsEvaluator($evaluatorValue);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($subject)));
    }
}
