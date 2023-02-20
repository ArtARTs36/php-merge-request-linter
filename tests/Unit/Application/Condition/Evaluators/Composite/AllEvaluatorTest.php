<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Composite;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AllEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AllEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                [
                    new MockConditionEvaluator(true),
                    new MockConditionEvaluator(true),
                ],
                true,
            ],
            [
                [
                    new MockConditionEvaluator(true),
                    new MockConditionEvaluator(false),
                ],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AllEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\CompositeEvaluator::__construct
     * @dataProvider providerForTestEvaluate
     * @param array<MockConditionEvaluator> $evaluators
     */
    public function testEvaluate(array $evaluators, bool $expected): void
    {
        $evaluator = new AllEvaluator($evaluators, new SubjectFactory(new MockPropertyExtractor(['value'])));

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject(['value'])));
    }
}
