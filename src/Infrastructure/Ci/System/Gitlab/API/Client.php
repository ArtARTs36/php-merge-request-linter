<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

class Client implements GitlabClient
{
    public function __construct(
        private readonly Authenticator   $credentials,
        private readonly ClientInterface $client,
        private readonly MergeRequestSchema      $schema,
        private readonly LoggerInterface $logger,
        private readonly TextDecoder     $textDecoder,
    ) {
        //
    }

    public function getMergeRequest(MergeRequestInput $input): MergeRequest
    {
        $this->logger->info(sprintf('[GitlabClient] Fetching Merge Request with id %d', $input->requestId));

        $url = sprintf(
            "%s/api/v4/projects/%d/merge_requests/%d/changes",
            $input->apiUrl,
            $input->projectId,
            $input->requestId,
        );

        $request = new Request('GET', $url);
        $request = $this->credentials->authenticate($request);

        $resp = $this->client->sendRequest($request);

        $response = $this->textDecoder->decode($resp->getBody()->getContents());

        $mergeRequest = $this->schema->createMergeRequest($response);

        $this->logger->info(sprintf('[GitlabClient] Merge Request with id %d was fetched', $input->requestId));

        return $mergeRequest;
    }
}
