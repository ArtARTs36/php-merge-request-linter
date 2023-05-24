<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo;

use ArtARTs36\ContextLogger\LoggerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change\ChangeSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonDecoder;
use ArtARTs36\MergeRequestLinter\Shared\Time\Clock;
use Psr\Log\NullLogger;

class ToolInfoFactory
{
    public function __construct(
        private readonly Clock $clock,
    ) {
        //
    }

    public function create(): \ArtARTs36\MergeRequestLinter\Domain\ToolInfo\ToolInfo
    {
        return new ToolInfo(
            new Client(
                new ClientGuzzleWrapper(new \GuzzleHttp\Client(), new NullLogger()),
                new NullAuthenticator(),
                new PullRequestSchema($this->clock),
                LoggerFactory::null(),
                new NativeJsonDecoder(),
                new ChangeSchema(new DiffMapper()),
            ),
        );
    }
}
