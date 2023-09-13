<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
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
                'projectCodes' => ['TASK'],
                'expectedNotes' => [],
            ],
            [
                $this->makeMergeRequest([
                    'source_branch' => 'TASK-1-super-feature',
                ]),
                'projectCodes' => [],
                'expectedNotes' => [],
            ],
            [
                $this->makeMergeRequest([
                    'source_branch' => 'aaaa',
                ]),
                'projectCodes' => [],
                'expectedNotes' => [
                    'Source branch must starts with task number',
                ],
            ],
            [
                $this->makeMergeRequest([
                    'source_branch' => 'TASK-1-super-feature',
                ]),
                'projectCodes' => ['ABC'],
                'expectedNotes' => ['Source branch must starts with task number of unknown project "TASK"'],
            ],
            [
                $this->makeMergeRequest([
                    'source_branch' => 'TASK- fix',
                ]),
                'projectCodes' => ['TASK'],
                'expectedNotes' => ['Source branch must starts with task number of projects [TASK]'],
            ],
            [
                $this->makeMergeRequest([
                    'source_branch' => 'AB TASK-1 feature',
                ]),
                'projectCodes' => ['TASK'],
                'expectedNotes' => ['Source branch must starts with task number of projects [TASK]'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\BranchStartsWithTaskNumberRule::__construct
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, array $projectCodes, array $expectedNotes): void
    {
        $rule = new BranchStartsWithTaskNumberRule(new Arrayee($projectCodes));

        self::assertSame(
            $expectedNotes,
            array_map('strval', $rule->lint($request)),
        );
    }
}
