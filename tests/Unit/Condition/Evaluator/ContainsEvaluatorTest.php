<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\ContainsEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ContainsEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            ['aabbaa', 'bb', true],
            ['aababaa', 'bb', false],
            [1234, '12', true],
            [1234, '11', false],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\ContainsEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\ContainsEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(mixed $propertyValue, mixed $value, bool $expected): void
    {
        $operator = new ContainsEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
