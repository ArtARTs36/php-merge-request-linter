<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\MergeRequestLinter\Tests\TestFor;

#[TestFor(TitleStartsWithTaskNumberRule::class)]
final class TitleStartsWithTaskNumberRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                new RuleTestDataSet(
                    [
                        'title' => 'TASK-1 project',
                    ],
                    [
                        'TASK',
                    ],
                    true,
                ),
            ],
            [
                new RuleTestDataSet(
                    [
                        'title' => 'TASK- project',
                    ],
                    [
                        'TASK',
                    ],
                    false,
                ),
            ],
            [
                new RuleTestDataSet(
                    [
                        'title' => 'AB TASK-1 project',
                    ],
                    [
                        'TASK',
                    ],
                    false,
                ),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::__construct
     * @dataProvider providerForTestLint
     */
    public function testLint(RuleTestDataSet $set): void
    {
        self::assertRuleLint(new TitleStartsWithTaskNumberRule(...$set->ruleValues), $set);
    }
}
