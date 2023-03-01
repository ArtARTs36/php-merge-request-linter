<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAllLabelsOfRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAllLabelsOfRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAllLabelsOfRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAllLabelsOfRule::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAllLabelsOfRule::getDefinition
     */
    public function testLint(MergeRequest $request, array $requestedLabels, bool $hasNotes): void
    {
        self::assertHasNotes($request, new HasAllLabelsOfRule(Set::fromList($requestedLabels)), $hasNotes);
    }
}
