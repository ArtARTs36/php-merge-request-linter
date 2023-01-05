<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\Env\VarName;
use ArtARTs36\MergeRequestLinter\Ci\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CI\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class GitlabCi implements CiSystem
{
    use InteractsWithResponse;

    public const NAME = 'gitlab_ci';

    public function __construct(
        protected RemoteCredentials $credentials,
        protected GitlabEnvironment $environment,
        protected ClientInterface $client,
    ) {
        //
    }

    public static function is(Environment $environment): bool
    {
        return $environment->has(VarName::Identity->value);
    }

    public function isMergeRequest(): bool
    {
        try {
            return $this->environment->getMergeRequestId() >= 0;
        } catch (EnvironmentVariableNotFound) {
            return false;
        }
    }

    public function getMergeRequest(): MergeRequest
    {
        $response = $this->client->sendRequest($this->makeHttpRequestForFetchMergeRequest());

        $this->validateResponse($response, self::NAME);

        $responseArray = $this->responseToJsonArray($response);

        $responseArray['changed_files_count'] = $responseArray['changes_count'];
        $responseArray['author_login'] = $responseArray['author']['username'];
        $responseArray['is_draft'] = $responseArray['draft'] ?? false;

        unset($responseArray['changes']);

        return MergeRequest::fromArray($responseArray);
    }

    protected function makeHttpRequestForFetchMergeRequest(): RequestInterface
    {
        [$projectId, $requestId] = [$this->environment->getProjectId(), $this->environment->getMergeRequestId()];

        return new Request('GET', $this->environment->getGitlabServerUrl() . "/api/v4/projects/$projectId/merge_requests/$requestId/changes", [
            'PRIVATE-TOKEN' => [
                $this->credentials->getToken(),
            ],
        ]);
    }
}
