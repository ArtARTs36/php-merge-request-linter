<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConditionOperator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConditionRuleTest extends TestCase
{
    public function providerForTestLintIncSkipRulesMetric(): array
    {
        return [
            [
                MockConditionOperator::true(),
                0,
            ],
            [
                MockConditionOperator::false(),
                1,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule::__construct
     * @dataProvider providerForTestLintIncSkipRulesMetric
     */
    public function testLintIncSkipRulesMetric(ConditionOperator $operator, int $expected): void
    {
        $rule = new ConditionRule(
            new SuccessRule(),
            $operator,
            $counter = new IncCounter(),
        );

        $rule->lint($this->makeMergeRequest());

        self::assertEquals($expected, $counter->getMetricValue());
    }
}
