<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Merge Request must contains links of all {domains}.
 */
class DescriptionContainsLinksOfAllDomainsRule extends AbstractDescriptionLinksRule implements Rule
{
    public function lint(MergeRequest $request): array
    {
        $hosts = [];

        foreach ($request->description->findUris() as $uri) {
            $hosts[(string) $uri] = true;
        }

        foreach ($this->domains as $domain) {
            if (! array_key_exists($domain, $hosts)) {
                return $this->definitionToNotes();
            }
        }

        return [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(
            "Merge Request must contains links of all domains: [" . $this->domains->implode(', ') . "]",
        );
    }
}
