<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MemoryCounter;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConditionRuleTest extends TestCase
{
    public function providerForTestLintIncSkipRulesMetric(): array
    {
        return [
            [
                new class implements ConditionOperator {
                    public function check(object $subject): bool
                    {
                        return true;
                    }
                },
                0,
            ],
            [
                new class implements ConditionOperator {
                    public function check(object $subject): bool
                    {
                        return false;
                    }
                },
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
            $counter = new MemoryCounter(),
        );

        $rule->lint($this->makeMergeRequest());

        self::assertEquals($expected, $counter->getMetricValue());
    }
}
