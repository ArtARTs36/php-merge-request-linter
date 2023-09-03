<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TitleStartsWithTaskNumberRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            'allowed any code' => [
                $this->makeMergeRequest([
                    'title' => 'TASK-1 project',
                ]),
                'projectCodes' => [],
                'expectedNotes' => [],
            ],
            'allowed one specified code' => [
                $this->makeMergeRequest([
                    'title' => 'TASK-1 project',
                ]),
                'projectCodes' => ['TASK'],
                'expectedNotes' => [],
            ],
            'allowed one from many specified codes' => [
                $this->makeMergeRequest([
                    'title' => 'TASK-1 project',
                ]),
                'projectCodes' => ['TASK', 'TASSK'],
                'expectedNotes' => [],
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'TASK- project',
                ]),
                'projectCodes' => ['TASK'],
                'expectedNotes' => ['Title must starts with task number of projects [TASK]'],
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'AB TASK-1 project',
                ]),
                'projectCodes' => ['TASK'],
                'expectedNotes' => ['Title must starts with task number of projects [TASK]'],
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'TASK-1 project',
                ]),
                'projectCodes' => ['TASKA'],
                'expectedNotes' => ['Title starts with task number of unknown project "TASK"'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::__construct
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, array $projectCodes, array $expectedNotes): void
    {
        $rule = new TitleStartsWithTaskNumberRule(new Arrayee($projectCodes));

        self::assertSame(
            $expectedNotes,
            array_map('strval', $rule->lint($request)),
        );
    }
}
