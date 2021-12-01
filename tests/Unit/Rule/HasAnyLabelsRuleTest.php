<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasAnyLabelsRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                true,
            ],
            [
                $this->makeMergeRequest([
                    'labels' => ['Feature'],
                ]),
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsRule::lint
     */
    public function testLint(MergeRequest $request, bool $hasNotes): void
    {
        self::assertEquals($hasNotes, count($this->makeLintRule()->lint($request)) > 0);
    }

    private function makeLintRule(): HasAnyLabelsRule
    {
        return new HasAnyLabelsRule();
    }
}
