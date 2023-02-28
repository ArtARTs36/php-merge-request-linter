<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\AbstractRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AbstractRuleTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\AbstractRule::getName
     */
    public function testGetName(): void
    {
        $rule = new class extends AbstractRule {
            public const NAME = 'test-rule';

            protected function doLint(MergeRequest $request): bool
            {
                // TODO: Implement doLint() method.
            }

            public function getDefinition(): RuleDefinition
            {
                // TODO: Implement getDefinition() method.
            }
        };

        self::assertEquals('test-rule', $rule->getName());
    }
}
