<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\CI\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Contracts\CI\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Line;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Type;
use ArtARTs36\Str\Str;
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

        $this->validateResponse($resp, $url);

        $response = $this->responseToJsonArray($resp);

        return new MergeRequest(
            $response['title'],
            $response['description'],
            $response['labels'],
            $response['has_conflicts'],
            $response['source_branch'],
            $response['target_branch'],
            count($response['changes']),
            $response['author']['username'],
            $response['draft'] ?? false,
            $response['merge_status'],
            $this->mapChanges($response['changes']),
        );
    }

    /**
     * @param array<array{new_path: string, old_path: string}> $response
     * @return array<Change>
     */
    private function mapChanges(array $response): array
    {
        $changes = [];

        foreach ($response as $change) {
            $changes[] = new Change($change['new_path'], $change['old_path'], $this->mapDiff($change));
        }

        return $changes;
    }

    /**
     * @param array<string> $response
     * @return array<Line>
     */
    private function mapDiff(array $response): array
    {
        $diff = [];

        foreach ($response as $respDiff) {
            $respDiffStr = Str::make($respDiff)->trim();

            /** @var Str $respLine */
            foreach ($respDiffStr->lines() as $respLine) {
                $type = Type::NOT_CHANGES;

                if ($respLine->startsWith('+')) {
                    $type = Type::NEW;
                    $respLine = $respLine->cut(null, start: 1);
                } elseif ($respLine->startsWith('-')) {
                    $type = Type::OLD;
                    $respLine = $respLine->cut(null, start: 1);
                }

                $diff[] = new Line(
                    $type,
                    $respLine,
                );
            }
        }

        return $diff;
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
