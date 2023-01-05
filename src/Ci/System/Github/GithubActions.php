<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Ci\System\Github\Env\VarName;
use ArtARTs36\MergeRequestLinter\Ci\System\Github\GraphQL\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Ci\System\Github\GraphQL\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Ci\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Client\ClientInterface;

class GithubActions implements CiSystem
{
    use InteractsWithResponse;

    public const NAME = 'github_actions';

    protected PullRequestSchema $schema;

    public function __construct(
        protected RemoteCredentials $credentials,
        protected GithubEnvironment $env,
        protected ClientInterface $client,
    ) {
        $this->schema = new PullRequestSchema();
    }

    public static function is(Environment $environment): bool
    {
        return $environment->has(VarName::Identity->value);
    }

    public function isMergeRequest(): bool
    {
        try {
            return $this->env->getMergeRequestId() >= 0;
        } catch (EnvironmentVariableNotFound) {
            return false;
        }
    }

    public function getMergeRequest(): MergeRequest
    {
        $graphqlUrl = $this->env->getGraphqlURL();
        $repo = $this->env->extractRepo();
        $requestId = $this->env->getMergeRequestId();

        $query = json_encode([
            'query' => $this->schema->createGraphqlForPullRequest(
                new PullRequestInput($repo->owner, $repo->name, $requestId),
            ),
        ]);

        $response = $this->client->sendRequest((new Request('POST', $graphqlUrl))
            ->withBody(StreamBuilder::streamFor($query))
            ->withHeader('Authorization', 'bearer ' . $this->credentials->getToken()));

        $this->validateResponse($response, self::NAME);

        return $this->schema->createMergeRequest(
            $this->responseToJsonArray($response)['data']['repository']['pullRequest']
        );
    }
}
