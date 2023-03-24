<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\Normalizer\Contracts\Denormalizer;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;

class Client
{
    public function __construct(
        private readonly Authenticator          $credentials,
        private readonly HttpClient             $http,
        private readonly LoggerInterface        $logger,
        private readonly TextDecoder            $textDecoder,
        private readonly Denormalizer           $denormalizer,
        private readonly BitbucketDiffMapper    $diffMapper = new BitbucketDiffMapper(),
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

        $pr = $this->denormalizer->denormalize(PullRequest::class, $responseArray);

        if ($pr->diffUrl !== null) {
            $changes = new MapProxy(function () use ($pr) {
                return new ArrayMap($this->fetchChanges($pr->diffUrl));
            });
        } else {
            $changes = new ArrayMap([]);
        }

        $pr->changes = $changes;

        return $pr;
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
}
