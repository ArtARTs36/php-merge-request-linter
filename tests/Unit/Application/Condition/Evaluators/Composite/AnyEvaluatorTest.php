<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Composite;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AnyEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AnyEvaluatorTest extends TestCase
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
                true,
            ],
            [
                [
                    new MockConditionEvaluator(false),
                    new MockConditionEvaluator(false),
                ],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AnyEvaluator::evaluate
     * @dataProvider providerForTestEvaluate
     * @param array<MockConditionEvaluator> $evaluators
     */
    public function testEvaluate(array $evaluators, bool $expected): void
    {
        $evaluator = new AnyEvaluator($evaluators, new SubjectFactory(new MockPropertyExtractor(['value'])));

        self::assertEquals($expected, $evaluator->evaluate(new MockEvaluatingSubject(['value'])));
    }
}
