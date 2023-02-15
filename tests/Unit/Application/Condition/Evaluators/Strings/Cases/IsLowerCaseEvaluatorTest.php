<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsLowerCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class IsLowerCaseEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                'StudlyCase',
                true,
                false,
            ],
            [
                'camelCase',
                true,
                false,
            ],
            [
                'lowercase',
                true,
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsLowerCaseEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsLowerCaseEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $subjectValue, bool $evaluatorValue, bool $expectedResult): void
    {
        $evaluator = new IsLowerCaseEvaluator($evaluatorValue);

        self::assertEquals($expectedResult, $evaluator->evaluate(new MockEvaluatingSubject($subjectValue)));
    }
}
