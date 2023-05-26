<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NonCriticalRule;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NonCriticalRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                new MockRule([
                    new ExceptionNote(new \Exception('exception note')),
                    new LintNote('lint note'),
                ]),
                [
                    new ExceptionNote(new \Exception('exception note')),
                    (new LintNote('lint note'))->withSeverity(NoteSeverity::Warning),
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NonCriticalRule::lint
     * @dataProvider providerForTestLint
     */
    public function testLint(Rule $decoratedRule, array $expectedNotes): void
    {
        $rule = new NonCriticalRule($decoratedRule);

        self::assertEquals(
            $expectedNotes,
            $rule->lint($this->makeMergeRequest()),
        );
    }
}
