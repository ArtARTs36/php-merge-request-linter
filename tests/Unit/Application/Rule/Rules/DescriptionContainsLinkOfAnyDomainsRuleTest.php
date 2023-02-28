<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionContainsLinkOfAnyDomainsRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
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
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionContainsLinkOfAnyDomainsRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionContainsLinkOfAnyDomainsRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionContainsLinkOfAnyDomainsRule::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionContainsLinkOfAnyDomainsRule::getDefinition
     */
    public function testLint(MergeRequest $request, array $domains, bool $hasNotes): void
    {
        self::assertHasNotes($request, new DescriptionContainsLinkOfAnyDomainsRule(Set::fromList($domains)), $hasNotes);
    }
}
