<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\InteractsWithResponse;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;

class Client
{
    use InteractsWithResponse;

    public function __construct(
        private readonly RemoteCredentials $credentials,
        private readonly \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client $http,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $url = sprintf(
            'https://%s/api/2.0/projects/%s/repos/%s/pull-requests/%s',
            $input->host,
            $input->projectKey,
            $input->repoName,
            $input->requestId,
        );

        $request = new Request('GET', $url);
        $request = $this->applyCredentials($request);
        $response = $this->http->sendRequest($request);

        return $this->makePullRequest($this->responseToJsonArray($response));
    }

    private function applyCredentials(Request $request): Request
    {
        if ($this->credentials->getToken() === '') {
            return $request;
        }

        return $request->withHeader('JWT', $this->credentials->getToken());
    }

    private function makePullRequest(array $data): PullRequest
    {
        return new PullRequest(
            $data['id'],
            $data['title'],
        );
    }
}
