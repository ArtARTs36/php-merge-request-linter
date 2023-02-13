<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\MatchEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\InvalidEvaluatorValueException;
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(mixed $propertyValue, string $value, bool $expected): void
    {
        $evaluator = new MatchEvaluator($value);

        self::assertTrue($expected === $evaluator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\MatchEvaluator::doEvaluate
     */
    public function testEvaluateOnInvalidRegexValueException(): void
    {
        self::expectException(InvalidEvaluatorValueException::class);

        $evaluator = new MatchEvaluator('test');

        $evaluator->evaluate(new MockEvaluatingSubject('string'));
    }
}
