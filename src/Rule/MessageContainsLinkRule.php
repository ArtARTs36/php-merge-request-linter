<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class MessageContainsLinkRule implements Rule
{
    public function __construct(protected string $domain)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {

    }
}
