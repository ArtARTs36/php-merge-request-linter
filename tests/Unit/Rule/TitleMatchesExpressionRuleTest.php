<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\TitleMatchesExpressionRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TitleMatchesExpressionRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                '/^\[TASK-\d\] solve \".*\"$/m',
                true,
            ],
            [
                $this->makeMergeRequest([
                    'title' => '[TASK-1] solve "page not loaded"'
                ]),
                '/^\[TASK-\d\] solve \".*\"$/m',
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\TitleMatchesExpressionRule::lint
     */
    public function testLint(MergeRequest $request, string $expression, bool $hasNotes): void
    {
        self::assertHasNotes($request, new TitleMatchesExpressionRule($expression), $hasNotes);
    }
}
