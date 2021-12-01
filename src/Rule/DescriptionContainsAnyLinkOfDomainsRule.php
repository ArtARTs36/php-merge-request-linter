<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class DescriptionContainsAnyLinkOfDomainsRule extends AbstractDescriptionLinksRule implements Rule
{
    public function lint(MergeRequest $request): array
    {
        $uris = $request->description->findUris();

        foreach ($uris as $uri) {
            $host = parse_url($uri, PHP_URL_HOST);

            if ($this->domains->has($host)) {
                return [];
            }
        }

        return $this->definitionToNotes();
    }

    public function getDefinition(): string
    {
        return "Merge Request must contains all links of domains: [" . $this->domains->implode(', ') . "]";
    }
}
