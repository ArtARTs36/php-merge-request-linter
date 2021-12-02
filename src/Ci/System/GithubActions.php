<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\Credentials\OnlyToken;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentDataKeyNotFound;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\Str\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;

class GithubActions implements CiSystem
{
    protected const MERGEABLE_STATE_CONFLICTING = 'CONFLICTING';

    public function __construct(protected OnlyToken $credentials, protected Environment $environment)
    {
        //
    }

    public function getMergeRequest(): MergeRequest
    {
        $graphqlUrl = $this->environment->getString('GITHUB_GRAPHQL_URL');
        [$repoOwner, $repoName] = $this->extractOwnerAndRepo();
        $requestId = $this->getMergeRequestId();

        $client = new Client();

        $query = json_encode([
            'query' => $this->compileGraphqlRequest($repoOwner, $repoName, $requestId),
        ]);

        $request = (new Request('POST', $graphqlUrl))
            ->withBody(new Stream(fopen('data://text/plain,' . $query, 'r')))
            ->withHeader('Authorization', 'bearer ' . $this->credentials->getToken());

        $response = json_decode($client->sendRequest($request)->getBody()->getContents(), true)['data']['repository']['pullRequest'] ?? [];

        return MergeRequest::fromArray([
            'title' => $response['title'],
            'description' => $response['bodyText'],
            'labels' => $this->getLabelsOfPullRequest($response),
            'has_conflicts' => $response['mergeable'] !== self::MERGEABLE_STATE_CONFLICTING,
        ]);
    }

    /**
     * @return array<string>
     */
    protected function getLabelsOfPullRequest(array $request): array
    {
        $labels = [];

        foreach ($request['labels']['nodes'] as $label) {
            $labels[] = $label['name'];
        }

        return $labels;
    }

    protected function extractOwnerAndRepo(): array
    {
        return \ArtARTs36\Str\Facade\Str::explode($this->environment->getString('GITHUB_REPOSITORY'), '/');
    }

    protected function getMergeRequestId(): int
    {
        $ref = Str::make($this->environment->getString('GITHUB_REF_NAME'));
        $id = $ref->deleteWhenEnds('/merge');

        if (! $id->isDigit()) {
            throw new EnvironmentDataKeyNotFound('GITHUB_REF_NAME');
        }

        return $id->toInteger();
    }

    protected function compileGraphqlRequest(string $owner, string $repo, int $requestId): string
    {
        return "query { 
  repository(owner: \"$owner\", name: \"$repo\") {
    pullRequest(number: $requestId) {
      title
      bodyText
      mergeable
      labels(first: 100) {
        totalCount
        nodes {
          name
        }
      }
    }
  }
}";
    }
}
