<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NamedRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NamedRuleTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NamedRule::getName
     */
    public function testGetName(): void
    {
        $rule = new class () extends NamedRule {
            public const NAME = 'test-rule';

            public function lint(MergeRequest $request): array
            {
                // TODO: Implement lint() method.
            }

            public function getDefinition(): RuleDefinition
            {
                // TODO: Implement getDefinition() method.
            }
        };

        self::assertEquals('test-rule', $rule->getName());
    }
}
