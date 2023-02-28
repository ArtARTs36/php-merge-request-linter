<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYouTrackIssueRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasLinkToYouTrackIssueRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                ['yt.my-company.ru', 'MY-PROJECT'],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'solve yt.my-company.ru/issue/MY-PROJECT-1',
                ]),
                ['yt.my-company.ru', 'MY-PROJECT'],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYoutrackIssueRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYoutrackIssueRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYoutrackIssueRule::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYoutrackIssueRule::getDefinition
     */
    public function testLint(MergeRequest $request, array $ruleParams, bool $hasNotes): void
    {
        self::assertHasNotes($request, new HasLinkToYouTrackIssueRule(...$ruleParams), $hasNotes);
    }
}
