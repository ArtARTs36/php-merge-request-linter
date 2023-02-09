<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\DescriptionContainsLinksOfAllDomainsRule;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DescriptionContainsLinksOfAllDomainsRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                ['site.ru', 'vk.com'],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'Hello on http://site.ru test'
                ]),
                ['site.ru', 'vk.com'],
                true,
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'Hello on http://site.ru and http://vk.com test'
                ]),
                ['site.ru', 'vk.com'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\DescriptionContainsLinksOfAllDomainsRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\DescriptionContainsLinksOfAllDomainsRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\DescriptionContainsLinksOfAllDomainsRule::__construct
     */
    public function testLint(MergeRequest $request, array $domains, bool $hasNotes): void
    {
        self::assertHasNotes($request, new DescriptionContainsLinksOfAllDomainsRule(Set::fromList($domains)), $hasNotes);
    }
}
