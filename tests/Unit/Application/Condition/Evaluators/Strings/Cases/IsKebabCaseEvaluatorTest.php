<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsKebabCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class IsKebabCaseEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                'kebab-case',
                true,
                true,
            ],
            [
                'camelCase',
                true,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsKebabCaseEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsKebabCaseEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $subjectValue, bool $evaluatorValue, bool $expectedResult): void
    {
        $evaluator = new IsKebabCaseEvaluator($evaluatorValue);

        self::assertEquals($expectedResult, $evaluator->evaluate(new MockEvaluatingSubject($subjectValue)));
    }
}
