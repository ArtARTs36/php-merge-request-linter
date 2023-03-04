<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangedFilesLimitRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\MergeRequestLinter\Tests\TestFor;

#[TestFor(ChangedFilesLimitRule::class)]
final class ChangedFilesLimitRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                new RuleTestDataSet(
                    ['changes' => array_fill(0, 10, 1)],
                    [5],
                    false,
                ),
            ],
            [
                new RuleTestDataSet(
                    ['changes' => array_fill(0, 5, 1)],
                    [10],
                    true,
                ),
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangedFilesLimitRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangedFilesLimitRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangedFilesLimitRule::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangedFilesLimitRule::getDefinition
     */
    public function testLint(RuleTestDataSet $set): void
    {
        self::assertRuleLint(new ChangedFilesLimitRule(...$set->ruleValues), $set);
    }
}
