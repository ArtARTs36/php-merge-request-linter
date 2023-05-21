<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NotHasAnyEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            'true' => [
                [1, 2, 3],
                [4],
                true,
            ],
            'false' => [
                [1, 2, 3],
                [1],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasAnyEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasAnyEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasAnyEvaluator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array $collection, array $evaluatorValue, bool $expected): void
    {
        $evaluator = new NotHasAnyEvaluator($evaluatorValue);

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject($collection)));
    }
}
