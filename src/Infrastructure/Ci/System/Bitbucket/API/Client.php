<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\InteractsWithResponse;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;

class Client
{
    use InteractsWithResponse;

    public function __construct(
        private readonly Authenticator                                                      $credentials,
        private readonly \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client $http,
        private readonly LoggerInterface                                                    $logger,
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $url = sprintf(
            'https://api.bitbucket.org/2.0/repositories/%s/%s/pullrequests/%s',
            $input->projectKey,
            $input->repoName,
            $input->requestId,
        );

        $this->logger->info(sprintf(
            '[BitbucketClient] fetching pull request at url "%s"',
            $url,
        ));

        $request = new Request('GET', $url);

        $request = $this->credentials->authenticate($request);

        $response = $this->http->sendRequest($request);
        $responseArray = $this->responseToJsonArray($response);

        return $this->makePullRequest($responseArray);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function makePullRequest(array $data): PullRequest
    {
        return new PullRequest(
            $data['id'],
            $data['title'],
            $data['author']['nickname'] ?? '',
            $data['source']['branch']['name'] ?? '',
            $data['destination']['branch']['name'] ?? '',
            new \DateTimeImmutable($data['created_on']),
            $data['links']['html']['href'] ?? '',
            $data['description'] ?? '',
            isset($data['state']) ? PullRequestState::tryFrom($data['state']) : null,
        );
    }
}
