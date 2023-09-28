<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector;
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
            $counter = CounterVector::null(),
        );

        $rule->lint($this->makeMergeRequest());

        self::assertEquals($expected, $counter->getFirstSampleValue());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule::__construct
     */
    public function testGetDefinition(): void
    {
        $rule = new ConditionRule(
            $subRule = new SuccessRule(),
            MockConditionOperator::true(),
            CounterVector::null(),
        );

        self::assertEquals($subRule->getDefinition(), $rule->getDefinition());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule::getName
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule::__construct
     */
    public function testGetName(): void
    {
        $rule = new ConditionRule(
            $subRule = new SuccessRule(),
            MockConditionOperator::true(),
            CounterVector::null(),
        );

        self::assertEquals($subRule->getName(), $rule->getName());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule::getDecoratedRules
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule::__construct
     */
    public function testGetDecoratedRules(): void
    {
        $rule = new ConditionRule(
            $subRule = new SuccessRule(),
            MockConditionOperator::true(),
            CounterVector::null(),
        );

        self::assertEquals([$subRule], $rule->getDecoratedRules());
    }
}
