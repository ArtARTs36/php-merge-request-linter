<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TitleStartsWithTaskNumberRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest([
                    'title' => 'TASK-1 project',
                ]),
                'TASK',
                false,
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'TASK- project',
                ]),
                'TASK',
                true,
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'AB TASK-1 project',
                ]),
                'TASK',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithTaskNumberRule::__construct
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, string $projectName, bool $hasNotes): void
    {
        self::assertHasNotes($request, new TitleStartsWithTaskNumberRule($projectName), $hasNotes);
    }
}
