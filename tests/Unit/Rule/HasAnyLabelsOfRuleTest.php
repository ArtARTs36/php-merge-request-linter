<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsOfRule;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsOfRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsOfRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsOfRule::__construct
     */
    public function testLint(MergeRequest $request, array $requestedLabels, bool $hasNotes): void
    {
        self::assertHasNotes($request, new HasAnyLabelsOfRule(Set::fromList($requestedLabels)), $hasNotes);
    }
}
