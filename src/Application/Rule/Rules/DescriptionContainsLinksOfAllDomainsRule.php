<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

#[Description('Merge Request must contain links of all {domains}.')]
final class DescriptionContainsLinksOfAllDomainsRule extends AbstractDescriptionLinksRule implements Rule
{
    public const NAME = '@mr-linter/description_contains_links_of_all_domains';

    protected function doLint(MergeRequest $request): bool
    {
        $hosts = [];

        foreach ($request->description->findUris() as $uri) {
            $hosts[(string) $uri] = true;
        }

        foreach ($this->domains as $domain) {
            if (! array_key_exists($domain, $hosts)) {
                return false;
            }
        }

        return true;
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(
            "Merge Request must contains link of all domains: [" . $this->domains->implode(', ') . "]",
        );
    }
}
