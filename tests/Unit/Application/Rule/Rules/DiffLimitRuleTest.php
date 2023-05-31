<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DiffLimitRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
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
                $this->makeMergeRequest(),
                false,
            ],
            [
                'linesMax' => 2,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', new Diff([
                            new DiffLine(DiffType::NOT_CHANGES, Str::fromEmpty()),
                            new DiffLine(DiffType::NOT_CHANGES, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                false,
            ],
            [
                'linesMax' => 2,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', new Diff([
                            new DiffLine(DiffType::NEW, Str::fromEmpty()),
                            new DiffLine(DiffType::NOT_CHANGES, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                false,
            ],
            [
                'linesMax' => 2,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', new Diff([
                            new DiffLine(DiffType::NEW, Str::fromEmpty()),
                            new DiffLine(DiffType::NOT_CHANGES, Str::fromEmpty()),
                        ])),
                    ],
                ]),
                false,
            ],
            [
                'linesMax' => 2,
                $this->makeMergeRequest([
                    'changes' => [
                        new Change('', new Diff([
                            new DiffLine(DiffType::NEW, Str::fromEmpty()),
                            new DiffLine(DiffType::NEW, Str::fromEmpty()),
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DiffLimitRule::__construct
     */
    public function testLint(int $linesMax, MergeRequest $request, bool $hasNotes): void
    {
        $rule = new DiffLimitRule($linesMax);

        self::assertHasNotes($request, $rule, $hasNotes);
    }
}
