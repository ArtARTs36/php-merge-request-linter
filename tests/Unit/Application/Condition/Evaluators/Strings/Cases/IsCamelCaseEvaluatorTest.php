<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsCamelCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class IsCamelCaseEvaluatorTest extends TestCase
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
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsCamelCaseEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsCamelCaseEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $subjectValue, bool $evaluatorValue, bool $expectedResult): void
    {
        $evaluator = new IsCamelCaseEvaluator($evaluatorValue);

        self::assertEquals($expectedResult, $evaluator->evaluate(new MockEvaluatingSubject($subjectValue)));
    }
}
