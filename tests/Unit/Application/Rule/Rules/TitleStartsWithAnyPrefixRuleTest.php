<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithAnyPrefixRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithAnyPrefixRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithAnyPrefixRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithAnyPrefixRule::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithAnyPrefixRule::getDefinition
     */
    public function testLint(MergeRequest $request, array $prefixes, bool $hasNotes): void
    {
        self::assertHasNotes($request, new TitleStartsWithAnyPrefixRule($prefixes), $hasNotes);
    }
}
