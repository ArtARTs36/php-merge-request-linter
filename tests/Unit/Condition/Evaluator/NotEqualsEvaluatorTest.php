<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NotEqualsEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                'dev',
                'master',
                true,
            ],
            [
                'dev',
                'dev',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator::doEvaluate
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator::__construct
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(string $propertyValue, string $value, bool $expected): void
    {
        $operator = new NotEqualsEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
