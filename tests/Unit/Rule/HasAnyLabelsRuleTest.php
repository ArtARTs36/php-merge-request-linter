<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
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
     * @covers \ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsRule::__construct
     */
    public function testLint(MergeRequest $request, bool $hasNotes): void
    {
        self::assertHasNotes($request, new HasAnyLabelsRule(), $hasNotes);
    }
}
