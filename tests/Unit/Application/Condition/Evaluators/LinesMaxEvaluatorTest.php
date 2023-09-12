<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LinesMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LinesMaxEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                'line1',
                1,
                true,
            ],
            [
                "line1\nlines2",
                1,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LinesMaxEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LinesMaxEvaluator::doEvaluate
     *
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $str, int $value, bool $expected): void
    {
        $evaluator = new LinesMaxEvaluator($value);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($str)));
    }
}
