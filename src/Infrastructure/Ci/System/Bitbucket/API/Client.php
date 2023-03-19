<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;

class Client
{
    public function __construct(
        private readonly Authenticator                                                      $credentials,
        private readonly \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client $http,
        private readonly LoggerInterface                                                    $logger,
        private readonly TextDecoder                                                        $textDecoder,
        private readonly BitbucketDiffMapper                                                $diffMapper = new BitbucketDiffMapper(),
    ) {
        //
    }

    /**
     * @link https://developer.atlassian.com/cloud/bitbucket/rest/api-group-pullrequests/#api-repositories-workspace-repo-slug-pullrequests-pull-request-id-get
     */
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
        $responseArray = $this->textDecoder->decode($response->getBody()->getContents());

        $diffUrl = $responseArray['links']['diff']['href'] ?? null;

        if (is_string($diffUrl)) {
            $changes = new MapProxy(function () use ($diffUrl) {
                return new ArrayMap($this->fetchChanges($diffUrl));
            });
        } else {
            $changes = new ArrayMap([]);
        }

        return $this->makePullRequest($responseArray, $changes);
    }

    /**
     * @return array<string, array<DiffLine>>
     */
    private function fetchChanges(string $url): array
    {
        $req = $this->credentials->authenticate(new Request('GET', $url));

        $resp = $this->http->sendRequest($req);

        return $this->diffMapper->map($resp->getBody()->getContents());
    }

    /**
     * @param array<string, mixed> $data
     * @param Map<string, array<DiffLine>> $changes
     */
    private function makePullRequest(array $data, Map $changes): PullRequest
    {
        return new PullRequest(
            $data['id'],
            $data['title'],
            $data['author']['nickname'] ?? '',
            $data['source']['branch']['name'] ?? '',
            $data['destination']['branch']['name'] ?? '',
            new \DateTimeImmutable($data['created_on']),
            $data['links']['html']['href'] ?? '',
            Str::make($data['description'] ?? ''),
            PullRequestState::create($data['state'] ?? ''),
            $changes,
        );
    }
}
