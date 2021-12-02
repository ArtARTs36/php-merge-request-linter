<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\WhenHasLabelMustDescriptionContainsLinkOfAnyDomainsRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class WhenHasLabelMustDescriptionContainsLinkOfAnyDomainsRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                ['Feature', ['http://domain.ru']],
                false,
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'Welcome to http://domain.ru test',
                    'labels' => ['Feature'],
                ]),
                ['Feature', ['domain.ru']],
                false,
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'Welcome test',
                    'labels' => ['Feature'],
                ]),
                ['Feature', ['domain.ru']],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\WhenHasLabelMustDescriptionContainsLinkOfAnyDomainsRule::lint
     */
    public function testLint(MergeRequest $request, array $ruleParams, bool $hasNotes): void
    {
        $this->assertHasNotes(
            $request,
            WhenHasLabelMustDescriptionContainsLinkOfAnyDomainsRule::make(...$ruleParams),
            $hasNotes
        );
    }
}
