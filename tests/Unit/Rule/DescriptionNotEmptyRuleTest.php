<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\DescriptionNotEmptyRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DescriptionNotEmptyRuleTest extends TestCase
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
                    'description' => 'Test',
                ]),
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\DescriptionNotEmptyRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\DescriptionNotEmptyRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\DescriptionNotEmptyRule::__construct
     */
    public function testLint(MergeRequest $request, bool $hasNotes): void
    {
        self::assertHasNotes($request, new DescriptionNotEmptyRule(), $hasNotes);
    }
}
