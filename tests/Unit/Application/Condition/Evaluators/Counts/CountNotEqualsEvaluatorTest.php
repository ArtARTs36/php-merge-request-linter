<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Counts;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountNotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CountNotEqualsEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                [],
                0,
                false,
            ],
            [
                [1],
                1,
                false,
            ],
            [
                [1],
                2,
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountNotEqualsEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountNotEqualsEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array $subject, int $evaluatorValue, bool $expected): void
    {
        $evaluator = new CountNotEqualsEvaluator($evaluatorValue);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($subject)));
    }
}
