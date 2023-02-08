<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TitleStartsWithAnyPrefixRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                ['TASK-'],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'TASK-1234 test'
                ]),
                ['TASK-'],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule::__construct
     */
    public function testLint(MergeRequest $request, array $prefixes, bool $hasNotes): void
    {
        self::assertHasNotes($request, new TitleStartsWithAnyPrefixRule($prefixes), $hasNotes);
    }
}
