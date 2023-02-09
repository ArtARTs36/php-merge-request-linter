<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\ChangedFilesLimitRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ChangedFilesLimitRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest([
                    'changes' => array_fill(0, 150, 1),
                ]),
                50,
                true,
            ],
            [
                $this->makeMergeRequest([
                    'changes' => array_fill(0, 40, 1),
                ]),
                50,
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\ChangedFilesLimitRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\ChangedFilesLimitRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\ChangedFilesLimitRule::__construct
     */
    public function testLint(MergeRequest $request, int $limit, bool $expected): void
    {
        self::assertHasNotes($request, new ChangedFilesLimitRule($limit), $expected);
    }
}
