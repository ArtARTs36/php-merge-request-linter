<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsRule::getDefinition
     */
    public function testLint(MergeRequest $request, bool $hasNotes): void
    {
        self::assertHasNotes($request, new HasAnyLabelsRule(), $hasNotes);
    }
}
