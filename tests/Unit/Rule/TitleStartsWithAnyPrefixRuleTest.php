<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TitleStartsWithAnyPrefixRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                'TASK-',
                true,
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'TASK-1234 test'
                ]),
                'TASK-',
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule::lint
     */
    public function testLint(MergeRequest $request, array|string $prefixes, bool $hasNotes): void
    {
        self::assertEquals($hasNotes, count(TitleStartsWithAnyPrefixRule::make($prefixes)->lint($request)) > 0);
    }
}