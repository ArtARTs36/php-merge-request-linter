<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use Psr\Log\NullLogger;

class ToolInfoFactory
{
    public function create(): \ArtARTs36\MergeRequestLinter\Domain\ToolInfo\ToolInfo
    {
        return new ToolInfo(
            new Client(
                new ClientGuzzleWrapper(new \GuzzleHttp\Client()),
                new NullAuthenticator(),
                new PullRequestSchema(),
                new DiffMapper(),
                new NullLogger(),
            ),
        );
    }
}
