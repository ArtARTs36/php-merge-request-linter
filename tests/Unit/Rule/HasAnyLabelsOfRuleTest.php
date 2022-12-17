<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsOfRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasAnyLabelsOfRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest([
                    'labels' => [],
                ]),
                [
                    'Feature',
                ],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'labels' => [
                        'Feature',
                    ],
                ]),
                [
                    'Feature',
                    'Backend',
                ],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsOfRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsOfRule::__construct
     */
    public function testLint(MergeRequest $request, array $requestedLabels, bool $hasNotes): void
    {
        self::assertHasNotes($request, HasAnyLabelsOfRule::make($requestedLabels), $hasNotes);
    }
}
