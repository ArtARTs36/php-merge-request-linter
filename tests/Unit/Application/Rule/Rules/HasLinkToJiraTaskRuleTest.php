<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToJiraTaskRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasLinkToJiraTaskRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                ['jira.my-company.ru', 'MY-PROJECT'],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'link to http://jira.my-company.ru/browse/MY-PROJECT-1',
                ]),
                ['jira.my-company.ru', 'MY-PROJECT'],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToJiraTaskRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToJiraTaskRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToJiraTaskRule::__construct
     */
    public function testLint(MergeRequest $request, array $ruleParams, bool $hasNotes): void
    {
        self::assertHasNotes($request, new HasLinkToJiraTaskRule(...$ruleParams), $hasNotes);
    }
}
