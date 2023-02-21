<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition\Operators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Operators\CompositeOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CompositeOperatorTest extends TestCase
{
    public function providerForTestCheck(): array
    {
        return [
            [
                [
                    MockConditionOperator::true(),
                    MockConditionOperator::true(),
                ],
                true,
            ],
            [
                [
                    MockConditionOperator::true(),
                    MockConditionOperator::false(),
                ],
                false,
            ],
            [
                [
                    MockConditionOperator::false(),
                    MockConditionOperator::false(),
                ],
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Operators\CompositeOperator::check
     * @covers \ArtARTs36\MergeRequestLinter\Application\Condition\Operators\CompositeOperator::__construct
     * @dataProvider providerForTestCheck
     */
    public function testCheck(array $subOperators, bool $expected): void
    {
        $operator = new CompositeOperator($subOperators);

        self::assertEquals($expected, $operator->check(new MockEvaluatingSubject('')));
    }
}
