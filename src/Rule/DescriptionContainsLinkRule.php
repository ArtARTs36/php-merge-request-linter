<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class DescriptionContainsLinkRule implements Rule
{
    public function __construct(protected array $domains)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {

    }

    public function getDefinition(): string
    {
        return "Merge Request' must contains link of domains: [" . implode(',', $this->domains) . "]";
    }
}
