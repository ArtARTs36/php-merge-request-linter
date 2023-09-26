<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Rule;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\FailRule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RulesTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Rule\Rules::add
     */
    public function testAdd(): void
    {
        $rules = new Rules([]);
        $rules->add(new SuccessRule());

        self::assertEquals(1, $rules->count());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Rule\Rules::implodeNames
     */
    public function testImplodeNames(): void
    {
        $rules = new Rules([
            new SuccessRule(),
            new FailRule(),
        ]);

        self::assertEquals('success_rule,fail_rule', $rules->implodeNames(','));
    }
}
