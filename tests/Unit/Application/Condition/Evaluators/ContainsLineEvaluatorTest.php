<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsLineEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainsLineEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                "a1\na2",
                'a1',
                true,
            ],
            [
                "a1\na2",
                'a3',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsLineEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsLineEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $subject, string $needLine, bool $expected): void
    {
        $evaluator = new ContainsLineEvaluator($needLine);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($subject)));
    }
}
