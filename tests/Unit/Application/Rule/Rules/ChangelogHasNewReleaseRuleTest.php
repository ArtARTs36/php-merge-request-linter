<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\ChangesConfig;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\ReleaseParser;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class ChangelogHasNewReleaseRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            'request not contains changes in changelog' => [
                $this->makeMergeRequest(),
                [
                    'file' => 'ch.md',
                    'changes' => new ChangesConfig(),
                ],
                [
                    'Changelog must be contained new release. Changelog not modified',
                ],
            ],
            'request not contains changes in changelog by default filenames' => [
                $this->makeMergeRequest(),
                [
                    'file' => null,
                    'changes' => new ChangesConfig(),
                ],
                [
                    'Changelog must be contained new release. Changelog not modified',
                ],
            ],
            'request has changes, but not contains new tag' => [
                $this->makeMergeRequest([
                    'changes' => [
                        'ch.md' => new Change('ch.md', Diff::fromList([
                            new DiffFragment(
                                DiffType::NEW,
                                Str::make('AB'),
                            ),
                        ]))
                    ],
                ]),
                [
                    'file' => 'ch.md',
                    'changes' => new ChangesConfig(),
                ],
                [
                    'Changelog was modified, but no has new release',
                ],
            ],
            'request has changes, but not contains new tag by default filename' => [
                $this->makeMergeRequest([
                    'changes' => [
                        'CHANGELOG' => new Change('CHANGELOG', Diff::fromList([
                            new DiffFragment(
                                DiffType::NEW,
                                Str::make('AB'),
                            ),
                        ])),
                    ],
                ]),
                [
                    'file' => null,
                    'changes' => new ChangesConfig(),
                ],
                [
                    'Changelog was modified, but no has new release',
                ],
            ],
            'lint failed: request contains new release without changes' => [
                $this->makeMergeRequest([
                    'changes' => [
                        'ch.md' => new Change('ch.md', Diff::fromList([
                            new DiffFragment(
                                DiffType::NEW,
                                Str::make("## 0.2.0\nAA\nBB"),
                            ),
                        ])),
                    ],
                ]),
                [
                    'file' => 'ch.md',
                    'changes' => new ChangesConfig(),
                ],
                [
                    'Changelog: release 0.2.0 not contains changes',
                ],
            ],
            'lint failed: request contains new release with unknown change type' => [
                $this->makeMergeRequest([
                    'changes' => [
                        'ch.md' => new Change('ch.md', Diff::fromList([
                            new DiffFragment(
                                DiffType::NEW,
                                Str::make("## 0.2.0\n### Unknown123 \n* Item 1\n* Item 2"),
                            ),
                        ])),
                    ],
                ]),
                [
                    'file' => 'ch.md',
                    'changes' => new ChangesConfig(),
                ],
                [
                    'Changelog: release 0.2.0 contains unknown change type "Unknown123"',
                ],
            ],
            'lint ok: request contains new release' => [
                $this->makeMergeRequest([
                    'changes' => [
                        'ch.md' => new Change('ch.md', Diff::fromList([
                            new DiffFragment(
                                DiffType::NEW,
                                Str::make("## 0.2.0\n### Added \n* Item 1\n* Item 2"),
                            ),
                        ])),
                    ],
                ]),
                [
                    'file' => 'ch.md',
                    'changes' => new ChangesConfig(),
                ],
                [],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule::getChangelog
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule::__construct
     */
    public function testLint(MergeRequest $request, array $ruleParams, array $expectNotes): void
    {
        $rule = new ChangelogHasNewReleaseRule(
            file: $ruleParams['file'],
            changes: $ruleParams['changes'],
            releaseParser: new ReleaseParser(),
        );

        self::assertEquals($expectNotes, array_map('strval', $rule->lint($request)));
    }
}
