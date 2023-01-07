<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\CI\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Contracts\CI\RemoteCredentials;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

class Client implements GitlabClient
{
    use InteractsWithResponse;

    public function __construct(
        private readonly RemoteCredentials $credentials,
        private readonly ClientInterface $client,
    ) {
        //
    }

    public function getMergeRequest(MergeRequestInput $input): MergeRequest
    {
        $url = sprintf(
            "%s/api/v4/projects/%d/merge_requests/%d/changes",
            $input->apiUrl,
            $input->projectId,
            $input->requestId,
        );

        $request = new Request('GET', $url, $this->authHeaders());

        $resp = $this->client->sendRequest($request);

        $this->validateResponse($resp, 'gitlab');

        $response = $this->responseToJsonArray($resp);

        return new MergeRequest(
            $response['title'],
            $response['description'],
            $response['labels'],
            $response['has_conflicts'],
            $response['source_branch'],
            $response['target_branch'],
            count($response['changed_files']),
            $response['author']['username'],
            $response['draft'] ?? false,
        );
    }

    /**
     * @return array<string, array<mixed>>
     */
    private function authHeaders(): array
    {
        return [
            'PRIVATE-TOKEN' => [
                $this->credentials->getToken(),
            ],
        ];
    }
}
