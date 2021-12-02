<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Rule\CallableRule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\EmptyNote;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CallableRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                fn () => true,
                false,
            ],
            [
                fn () => false,
                true,
            ],
            [
                fn () => [],
                false,
            ],
            [
                fn () => [new EmptyNote()],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\CallableRule::lint
     */
    public function testLint(callable $callback, bool $hasNotes): void
    {
        self::assertHasNotes($this->makeMergeRequest(), new CallableRule($callback, ''), $hasNotes);
    }
}
