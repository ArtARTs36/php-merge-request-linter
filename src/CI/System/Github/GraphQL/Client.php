<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL;

use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\CI\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Contracts\CI\RemoteCredentials;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Client\ClientInterface;

class Client implements GithubClient
{
    use InteractsWithResponse;

    public function __construct(
        private readonly ClientInterface $client,
        private readonly RemoteCredentials $credentials,
        private readonly PullRequestSchema $pullRequestSchema,
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $query = json_encode([
            'query' => $this->pullRequestSchema->createQuery($input),
        ]);

        $response = $this->client->sendRequest((new Request('POST', $input->graphqlUrl))
            ->withBody(StreamBuilder::streamFor($query))
            ->withHeader('Authorization', 'bearer ' . $this->credentials->getToken()));

        $this->validateResponse($response, $input->graphqlUrl);

        return $this->pullRequestSchema->createPullRequest($this->responseToJsonArray($response));
    }
}
