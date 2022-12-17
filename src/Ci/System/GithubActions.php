<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\System\Schema\GithubPullRequestSchema;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Client\ClientInterface;

class GithubActions implements CiSystem
{
    use InteractsWithResponse;

    public const NAME = 'github_actions';

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
        } catch (EnvironmentVariableNotFound) {
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

        $response = $this->client->sendRequest((new Request('POST', $graphqlUrl))
            ->withBody(StreamBuilder::streamFor($query))
            ->withHeader('Authorization', 'bearer ' . $this->credentials->getToken()));

        $this->validateResponse($response, self::NAME);

        return $this->schema->createMergeRequest(
            $this->responseToJsonArray($response)['data']['repository']['pullRequest']
        );
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
            throw new EnvironmentVariableNotFound('GITHUB_REF_NAME');
        }

        return $id->toInteger();
    }
}
