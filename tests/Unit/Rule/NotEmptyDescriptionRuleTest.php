<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\DescriptionNotEmptyRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NotEmptyDescriptionRuleTest extends TestCase
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
     * @covers \ArtARTs36\MergeRequestLinter\Rule\NotEmptyDescriptionRule::lint
     */
    public function testLint(MergeRequest $request, bool $hasNotes): void
    {
        self::assertEquals($hasNotes, count((new DescriptionNotEmptyRule())->lint($request)) > 0);
    }
}
