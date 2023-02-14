<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LengthMinEvaluatorTest extends TestCase
{
    public function providerForEvaluate(): array
    {
        return [
            [
                'title',
                3,
                true,
            ],
            [
                'title',
                10,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMinOperator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMinOperator::doEvaluate
     * @dataProvider providerForEvaluate
     */
    public function testEvaluate(string $propertyValue, int $value, bool $expected): void
    {
        $operator = new LengthMinOperator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
