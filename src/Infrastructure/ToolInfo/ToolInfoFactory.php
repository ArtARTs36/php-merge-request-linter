<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo;

use ArtARTs36\ContextLogger\LoggerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change\ChangeSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor;
use ArtARTs36\MergeRequestLinter\Shared\Time\Clock;
use Psr\Log\NullLogger;

class ToolInfoFactory
{
    public function __construct(
        private readonly Clock $clock,
    ) {
    }

    public function create(): \ArtARTs36\MergeRequestLinter\Domain\ToolInfo\ToolInfo
    {
        return new ToolInfo(
            new Client(
                new ClientGuzzleWrapper(new \GuzzleHttp\Client(), new NullLogger()),
                new NullAuthenticator(),
                new PullRequestSchema($this->clock),
                LoggerFactory::null(),
                new NativeJsonProcessor(),
                new ChangeSchema(new DiffMapper()),
            ),
        );
    }
}
