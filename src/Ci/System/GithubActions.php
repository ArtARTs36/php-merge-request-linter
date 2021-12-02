<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\System\Schema\GithubPullRequestSchema;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentDataKeyNotFound;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class GithubActions implements CiSystem
{
    protected GithubPullRequestSchema $schema;

    public function __construct(
        protected RemoteCredentials $credentials,
        protected Environment $environment,
        protected ClientInterface $client,
    ) {
        $this->schema = new GithubPullRequestSchema();
    }

    public static function is(Environment $environment): bool
    {
        return $environment->has('GITHUB_ACTIONS');
    }

    public function isMergeRequest(): bool
    {
        try {
            return $this->getMergeRequestId() >= 0;
        } catch (EnvironmentDataKeyNotFound) {
            return false;
        }
    }

    public function getMergeRequest(): MergeRequest
    {
        $graphqlUrl = $this->environment->getString('GITHUB_GRAPHQL_URL');
        [$repoOwner, $repoName] = $this->extractOwnerAndRepo();
        $requestId = $this->getMergeRequestId();

        $query = json_encode([
            'query' => $this->schema->createGraphqlForPullRequest($repoOwner, $repoName, $requestId),
        ]);

        $request = (new Request('POST', $graphqlUrl))
            ->withBody(new Stream(
                fopen('data://text/plain,' . $query, 'r') ?: throw new \RuntimeException('Stream not constructed')
            ))
            ->withHeader('Authorization', 'bearer ' . $this->credentials->getToken());

        return $this->schema->createMergeRequest($this->fetchPullRequestData($request));
    }

    /**
     * @return array<string, mixed>
     */
    protected function fetchPullRequestData(RequestInterface $request): array
    {
        return json_decode($this->client->sendRequest($request)->getBody()->getContents(), true)['data']['repository']['pullRequest'] ?? [];
    }

    /**
     * @return array<string>
     */
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
}
