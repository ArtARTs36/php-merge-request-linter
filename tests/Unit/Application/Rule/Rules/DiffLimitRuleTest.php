<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DiffLimitRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class DiffLimitRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                'linesMax' => 2,
                'fileLinesMax' => null,
                $this->makeMergeRequest(),
                false,
            ],
            [
                'linesMax' => 2,
                'fileLinesMax' => null,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', Diff::fromList([
                            new DiffFragment(DiffType::NOT_CHANGES, Str::fromEmpty()),
                            new DiffFragment(DiffType::NOT_CHANGES, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                false,
            ],
            [
                'linesMax' => 2,
                'fileLinesMax' => null,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                            new DiffFragment(DiffType::NOT_CHANGES, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                false,
            ],
            [
                'linesMax' => 2,
                'fileLinesMax' => null,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                            new DiffFragment(DiffType::NOT_CHANGES, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                false,
            ],
            [
                'linesMax' => 2,
                'fileLinesMax' => null,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                true,
            ],
            [
                'linesMax' => 5,
                'fileLinesMax' => 1,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                        new Change('', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                        new Change('', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DiffLimitRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DiffLimitRule::createNoteLinesMaxLimitExceeded
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DiffLimitRule::createNoteFileLinesLimitExceeded
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DiffLimitRule::__construct
     */
    public function testLint(int $linesMax, ?int $fileLinesMax, MergeRequest $request, bool $hasNotes): void
    {
        $rule = new DiffLimitRule($linesMax, $fileLinesMax);

        self::assertHasNotes($request, $rule, $hasNotes);
    }

    public static function providerForTestGetDefinition(): array
    {
        return [
            [
                'ruleParams' => [
                    'linesMax' => 5,
                    'fileLinesMax' => null,
                ],
                'expectedDefinition' => 'The request must contain no more than 5 changes.',
            ],
            [
                'ruleParams' => [
                    'linesMax' => null,
                    'fileLinesMax' => 6,
                ],
                'expectedDefinition' => 'The request must contain no more than 6 changes in a file.',
            ],
            [
                'ruleParams' => [
                    'linesMax' => 5,
                    'fileLinesMax' => 6,
                ],
                'expectedDefinition' => 'The request must contain no more than 5 changes. The request must contain no more than 6 changes in a file.',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DiffLimitRule::lint
     *
     * @dataProvider providerForTestGetDefinition
     */
    public function testGetDefinition(array $ruleParams, string $expectedDefinition): void
    {
        $rule = new DiffLimitRule(...$ruleParams);

        self::assertEquals($expectedDefinition, $rule->getDefinition()->getDescription());
    }
}
