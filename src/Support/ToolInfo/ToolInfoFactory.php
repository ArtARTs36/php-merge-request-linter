<?php

namespace ArtARTs36\MergeRequestLinter\Support\ToolInfo;

use ArtARTs36\MergeRequestLinter\CI\Credentials\Token;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Client;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Support\DiffMapper;

class ToolInfoFactory
{
    public function create(): ToolInfo
    {
        return new ToolInfo(
            new Client(new \GuzzleHttp\Client(), new Token(''), new PullRequestSchema(), new DiffMapper()),
        );
    }
}
