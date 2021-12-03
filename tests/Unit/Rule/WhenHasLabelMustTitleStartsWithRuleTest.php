<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\WhenHasLabelMustTitleStartsWithRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class WhenHasLabelMustTitleStartsWithRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest([]),
                ['Feature', 'TASK-'],
                false,
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'TASK-1 Init',
                    'labels' => [
                        'Feature',
                    ],
                ]),
                ['Feature', 'TASK-'],
                false,
            ],
            [
                $this->makeMergeRequest([
                    'title' => 'Test Init',
                    'labels' => [
                        'Feature',
                    ],
                ]),
                ['Feature', 'TASK-'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\WhenHasLabelMustTitleStartsWithRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\WhenHasLabelMustTitleStartsWithRule::__construct
     */
    public function testLint(MergeRequest $request, array $ruleParams, bool $hasNotes): void
    {
        self::assertHasNotes($request, (new WhenHasLabelMustTitleStartsWithRule(...$ruleParams)), $hasNotes);
    }
}
