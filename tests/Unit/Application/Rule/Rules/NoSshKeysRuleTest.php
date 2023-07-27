<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NoSshKeysRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class NoSshKeysRuleTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NoSshKeysRule::lint
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $mergeRequest, bool $stopOnFirstFailure, array $expectedNotes): void
    {
        $rule = new NoSshKeysRule($stopOnFirstFailure);

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
                        new Change('success.txt', new Diff([
                            new DiffLine(DiffType::NEW, Str::make('ssh-rsa random-text')),
                        ])),
                    ],
                ]),
                false,
                [],
            ],
            [
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('failed.txt', new Diff([
                            new DiffLine(DiffType::NEW, Str::make('ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEAklOUpkDHrfHY17SbrmTIpNLTGK9Tjom/BWDSUGPl+nafzlHDTYW7hdI4yZ5ew18JH4JW9jbhUFrviQzM7xlELEVf4h9lFX5QVkbPppSwg0cda3Pbv7kOdJ/MTyBlWXFCR+HAo3FXRitBqxiX1nKhXpHAZsMciLq8V6RjsNAQwdsdMFvSlVK/7XAt3FaoJoAsncM1Q9x5+3V0Ww68/eIFmb1zuUFljQJKprrX88XypNDvjYNby6vw/Pb0rwert/EnmZ+AW4OZPnTPI89ZPmVMLuayrD2cE86Z/il8b+gw3r3+1nKatmIkjn2so1d01QraTlMqVSsbxNrRFi9wrf+M7Q== schacon@mylaptop.local')),
                        ])),
                        new Change('success.txt', new Diff([
                            new DiffLine(DiffType::NEW, Str::make('ssh-rsa random-text')),
                        ])),
                    ],
                ]),
                false,
                ['File "failed.txt" contains ssh key (ssh-rsa)'],
            ],
        ];
    }
}
