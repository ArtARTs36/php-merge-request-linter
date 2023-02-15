<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Condition\Evaluators\Counts;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CountMaxEvaluatorTest extends TestCase
{
    public function providerForTestEvaluate(): array
    {
        return [
            [
                [],
                0,
                true,
            ],
            [
                [1],
                10,
                true,
            ],
            [
                [1],
                1,
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountMaxEvaluator::evaluate
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountMaxEvaluator::doEvaluate
     * @dataProvider providerForTestEvaluate
     */
    public function testEvaluate(array|ArrayMap $propertyValue, int $value, bool $expected): void
    {
        $operator = new CountMaxEvaluator($value);

        self::assertEquals($expected, $operator->evaluate(new MockEvaluatingSubject($propertyValue)));
    }
}
