<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsSnakeCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class IsSnakeCaseEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                'ab_cd',
                true,
                true,
            ],
            [
                'abCD',
                true,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsSnakeCaseEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsSnakeCaseEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $subjectValue, bool $evaluatorValue, bool $expectedResult): void
    {
        $evaluator = new IsSnakeCaseEvaluator($evaluatorValue);

        self::assertEquals($expectedResult, $evaluator->evaluate(new MockEvaluatingSubject($subjectValue)));
    }
}
