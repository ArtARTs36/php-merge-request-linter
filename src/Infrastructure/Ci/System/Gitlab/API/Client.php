<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\Normalizer\Contracts\Denormalizer;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

class Client implements GitlabClient
{
    public function __construct(
        private readonly Authenticator   $credentials,
        private readonly ClientInterface $client,
        private readonly DiffMapper      $diffMapper,
        private readonly LoggerInterface $logger,
        private readonly TextDecoder     $textDecoder,
        private readonly Denormalizer    $denormalizer,
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

        $mergeRequest = $this->denormalizer->denormalize(MergeRequest::class, $response);
        $mergeRequest->changes = $this->mapChanges($response);

        $this->logger->info(sprintf('[GitlabClient] Merge Request with id %d was fetched', $input->requestId));

        return $mergeRequest;
    }

    /**
     * @param array<array{new_path: string, old_path: string, diff: string|null}> $response
     * @return array<Change>
     */
    private function mapChanges(array $response): array
    {
        $changes = [];

        foreach ($response as $change) {
            $changes[] = new Change($change['new_path'], $change['old_path'], $this->diffMapper->map($change['diff'] ?? ''));
        }

        return $changes;
    }
}
