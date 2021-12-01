<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\Map;

class DescriptionContainsAnyLinkRule implements Rule
{
    public function __construct(protected Map $domains)
    {
        //
    }

    public static function make(array $domains): self
    {
        return new self(Map::fromList($domains));
    }

    public function lint(MergeRequest $request): array
    {
        $uris = $request->description->findUris();

        foreach ($uris as $uri) {
            $host = parse_url($uri, PHP_URL_HOST);

            if ($this->domains->has($host)) {
                return [];
            }
        }

        return [new LintNote($this->getDefinition())];
    }

    public function getDefinition(): string
    {
        return "Merge Request must contains all links of domains: [" . $this->domains->implode(', ') . "]";
    }
}
