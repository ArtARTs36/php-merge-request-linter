<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYouTrackIssueRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class UpdateChangelogRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            'request not contains changes in changelog' => [
                $this->makeMergeRequest(),
                [
                    'ch.md',
                    new UpdateChangelogRule\Tags(
                        new UpdateChangelogRule\TagsHeading(2),
                    ),
                ],
                [
                    'Changelog must be contained new tag',
                ],
            ],
            'request has changes, but not contains new tag' => [
                $this->makeMergeRequest([
                    'changes' => [
                        'ch.md' => new Change('ch.md', new Diff([
                            new DiffLine(
                                DiffType::NEW,
                                Str::make('AB'),
                            ),
                        ]))
                    ],
                ]),
                [
                    'ch.md',
                    new UpdateChangelogRule\Tags(
                        new UpdateChangelogRule\TagsHeading(2),
                    ),
                ],
                [
                    'Changelog has changes, but hasn\'t new tag',
                ],
            ],
            'request contains new tag' => [
                $this->makeMergeRequest([
                    'changes' => [
                        'ch.md' => new Change('ch.md', new Diff([
                            new DiffLine(
                                DiffType::NEW,
                                Str::make('## 0.2.0'),
                            ),
                        ]))
                    ],
                ]),
                [
                    'ch.md',
                    new UpdateChangelogRule\Tags(
                        new UpdateChangelogRule\TagsHeading(2),
                    ),
                ],
                [],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule::getChangelog
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule::__construct
     */
    public function testLint(MergeRequest $request, array $ruleParams, array $expectNotes): void
    {
        $rule = new UpdateChangelogRule(...$ruleParams);

        self::assertEquals($expectNotes, array_map('strval', $rule->lint($request)));
    }
}
