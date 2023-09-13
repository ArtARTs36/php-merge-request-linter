<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NoSshKeysRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SshKeyFinderMock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class NoSshKeysRuleTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NoSshKeysRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NoSshKeysRule::findSshKeysTypes
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NoSshKeysRule::__construct
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $mergeRequest, bool $stopOnFirstFailure, array $foundSshTypes, array $expectedNotes): void
    {
        $rule = new NoSshKeysRule(new SshKeyFinderMock($foundSshTypes), $stopOnFirstFailure);

        $givenResult = $rule->lint($mergeRequest);

        self::assertEquals(
            $expectedNotes,
            array_map('strval', $givenResult),
        );
    }

    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('success.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::make('ssh-rsa random-text')),
                        ])),
                    ],
                ]),
                false,
                [],
                [],
            ],
            [
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('failed.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::make('ssh-rsa text')),
                        ])),
                        new Change('failed2.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::make('ssh-rsa2 text')),
                        ])),
                    ],
                ]),
                false,
                [
                    'ssh-rsa text' => ['ssh-rsa'],
                    'ssh-rsa2 text' => ['ssh-rsa'],
                ],
                [
                    'File "failed.txt" contains ssh key (ssh-rsa)',
                    'File "failed2.txt" contains ssh key (ssh-rsa)',
                ],
            ],
            [
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('failed.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::make('ssh-rsa text')),
                        ])),
                        new Change('failed2.txt', Diff::fromList([
                            new DiffFragment(DiffType::NEW, Str::make('ssh-rsa2 text')),
                        ])),
                    ],
                ]),
                true,
                [
                    'ssh-rsa text' => ['ssh-rsa'],
                    'ssh-rsa2 text' => ['ssh-rsa'],
                ],
                [
                    'File "failed.txt" contains ssh key (ssh-rsa)',
                ],
            ],
        ];
    }
}
