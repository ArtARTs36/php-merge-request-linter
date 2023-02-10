<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotStartsEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NotStartsEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            ['babcd', 'ab', true],
            ['abcd', 'ab', false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotStartsEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotStartsEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(mixed $propertyValue, string $value, bool $expected): void
    {
        $operator = new NotStartsEvaluator($value);

        self::assertTrue($expected === $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
