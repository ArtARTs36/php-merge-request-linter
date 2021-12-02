<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\DescriptionContainsLinkOfAnyDomainsRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DescriptionContainsLinkOfAnyDomainsRuleTest extends TestCase
{
    public function providerForLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                ['site.ru'],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'Hello on http://site.ru test',
                ]),
                ['site.ru', 'vk.com'],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\DescriptionContainsLinkOfAnyDomainsRule::lint
     */
    public function testLint(MergeRequest $request, array $domains, bool $hasNotes): void
    {
        self::assertEquals(
            $hasNotes,
            count(DescriptionContainsLinkOfAnyDomainsRule::make($domains)->lint($request)) > 0,
        );
    }
}
