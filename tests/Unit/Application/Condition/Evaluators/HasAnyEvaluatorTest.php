<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\HasAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasAnyEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            'true' => [
                [1, 2, 3],
                [1],
                true,
            ],
            'false' => [
                [1, 2, 3],
                [4],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\HasAnyEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\HasAnyEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\HasAnyEvaluator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array $collection, array $evaluatorValue, bool $expected): void
    {
        $evaluator = new HasAnyEvaluator($evaluatorValue);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($collection)));
    }
}
