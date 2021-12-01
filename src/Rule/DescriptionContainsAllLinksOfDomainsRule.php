<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class DescriptionContainsAllLinksOfDomainsRule extends AbstractDescriptionLinksRule implements Rule
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

    public function getDefinition(): string
    {
        return "Merge Request must contains all links of domains: [" . $this->domains->implode(', ') . "]";
    }
}
