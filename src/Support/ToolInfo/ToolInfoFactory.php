<?php

namespace ArtARTs36\MergeRequestLinter\Support\ToolInfo;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use Psr\Log\NullLogger;

class ToolInfoFactory
{
    public function create(): ToolInfo
    {
        return new ToolInfo(
            new Client(
                new ClientGuzzleWrapper(new \GuzzleHttp\Client()),
                new Token(''),
                new PullRequestSchema(),
                new DiffMapper(),
                new NullLogger(),
            ),
        );
    }
}
