<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LengthMaxEvaluatorTest extends TestCase
{
    public function providerForEvaluate(): array
    {
        return [
            [
                'title',
                5,
                true,
            ],
            [
                'title',
                3,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMaxEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMaxEvaluator::doEvaluate
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(string $propertyValue, int $value, bool $expected): void
    {
        $operator = new LengthMaxEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
