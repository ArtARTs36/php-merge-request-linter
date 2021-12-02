<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\HasAllLabelsOfRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasAllLabelsOfRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest([
                    'labels' => [],
                ]),
                ['Feature', 'Backend'],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'labels' => [
                        'Feature',
                    ],
                ]),
                ['Feature', 'Backend'],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'labels' => [
                        'Feature', 'Backend',
                    ],
                ]),
                ['Feature', 'Backend'],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\HasAllLabelsOfRule::lint
     */
    public function testLint(MergeRequest $request, array $requestedLabels, bool $hasNotes): void
    {
        self::assertEquals($hasNotes, count(HasAllLabelsOfRule::make($requestedLabels)->lint($request)) > 0);
    }
}