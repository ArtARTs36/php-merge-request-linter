<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Condition\Evaluator\MatchEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

class MatchEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            ['-- ab', '/ab/i', true],
            ['-- a1b', '/ab/', false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotStartsEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotStartsEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(mixed $propertyValue, string $value, bool $expected): void
    {
        $operator = new MatchEvaluator($value);

        self::assertTrue($expected === $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
