<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class BranchStartsWithTaskNumberRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest([
                    'source_branch' => 'TASK-1-super-feature',
                ]),
                'TASK',
                false,
            ],
            [
                $this->makeMergeRequest([
                    'source_branch' => 'TASK- fix',
                ]),
                'TASK',
                true,
            ],
            [
                $this->makeMergeRequest([
                    'source_branch' => 'AB TASK-1 feature',
                ]),
                'TASK',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule::__construct
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, string $projectName, bool $hasNotes): void
    {
        self::assertHasNotes($request, new BranchStartsWithTaskNumberRule($projectName), $hasNotes);
    }
}
