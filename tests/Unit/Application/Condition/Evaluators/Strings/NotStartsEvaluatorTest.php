<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsEvaluator;
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(mixed $propertyValue, string $value, bool $expected): void
    {
        $operator = new NotStartsEvaluator($value);

        self::assertTrue($expected === $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
