<?php

namespace ArtARTs36\MergeRequestLinter\Support\ToolInfo;

use ArtARTs36\MergeRequestLinter\CI\Credentials\Token;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Client;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\DiffMapper;
use Psr\Log\NullLogger;

class ToolInfoFactory
{
    public function create(): ToolInfo
    {
        return new ToolInfo(
            new Client(
                new \ArtARTs36\MergeRequestLinter\Support\Http\ClientGuzzleWrapper(new \GuzzleHttp\Client()),
                new Token(''),
                new PullRequestSchema(),
                new DiffMapper(),
                new NullLogger(),
                new NullMetricManager(),
            ),
        );
    }
}
