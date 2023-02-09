<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Merge Request must contain links of any {domains}.
 */
class DescriptionContainsLinkOfAnyDomainsRule extends AbstractDescriptionLinksRule implements Rule
{
    public const NAME = '@mr-linter/description_contains_links_of_any_domains';

    protected function doLint(MergeRequest $request): bool
    {
        $uris = $request->description->findUris();

        foreach ($uris as $uri) {
            $host = parse_url($uri, PHP_URL_HOST);

            if ($host === false || $host === null) {
                continue;
            }

            if ($this->domains->contains($host)) {
                return true;
            }
        }

        return false;
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(
            "Merge Request must contains link of any domains: [" . $this->domains->implode(', ') . "]",
        );
    }
}
