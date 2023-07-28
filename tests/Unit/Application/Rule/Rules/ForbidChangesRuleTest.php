<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ForbidChangesRule;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class ForbidChangesRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                ['file.txt'],
                $this->makeMergeRequest([
                    'changes' => [
                        'file.txt' => new Change('file.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                [
                    new LintNote('Changes forbidden in file: file.txt'),
                ],
            ],
            //
            [
                [],
                $this->makeMergeRequest([
                    'changes' => [
                        'file.txt' => new Change('file.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                [],
            ],
            //
            [
                ['file.txt', 'file2.txt'],
                $this->makeMergeRequest([
                    'changes' => [
                        'file.txt' => new Change('file.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                [
                    new LintNote('Changes forbidden in file: file.txt'),
                ],
            ],
            //
            [
                ['file.txt', 'file2.txt'],
                $this->makeMergeRequest([
                    'changes' => [
                        'file.txt' => new Change('file.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                        'file2.txt' => new Change('file2.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                [
                    new LintNote('Changes forbidden in file: file.txt'),
                    new LintNote('Changes forbidden in file: file2.txt'),
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ForbidChangesRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ForbidChangesRule::__construct
     * @dataProvider providerForTestLint
     */
    public function testLint(array $files, MergeRequest $request, array $expectedNotes): void
    {
        $rule = new ForbidChangesRule(Set::fromList($files));

        self::assertEquals($expectedNotes, $rule->lint($request));
    }

    public function providerForTestGetDefinition(): array
    {
        return [
            [
                ['file.txt'],
                'Changes forbidden in file "file.txt"',
            ],
            [
                ['file1.txt', 'file2.txt'],
                'Changes forbidden in files: [file1.txt, file2.txt]',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ForbidChangesRule::getDefinition
     * @dataProvider providerForTestGetDefinition
     */
    public function testGetDefinition(array $files, string $expected): void
    {
        $rule = new ForbidChangesRule(Set::fromList($files));

        self::assertEquals($expected, $rule->getDefinition());
    }
}
