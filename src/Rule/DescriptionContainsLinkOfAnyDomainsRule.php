<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Merge Request must contains links of any {domains}.
 */
class DescriptionContainsLinkOfAnyDomainsRule extends AbstractDescriptionLinksRule implements Rule
{
    public function lint(MergeRequest $request): array
    {
        $uris = $request->description->findUris();

        foreach ($uris as $uri) {
            $host = parse_url($uri, PHP_URL_HOST);

            if ($host === false || $host === null) {
                continue;
            }

            if ($this->domains->has($host)) {
                return [];
            }
        }

        return $this->definitionToNotes();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(
            "Merge Request must contains links of any domains: [" . $this->domains->implode(', ') . "]",
        );
    }
}
