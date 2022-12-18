<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\Env\VarName;
use ArtARTs36\MergeRequestLinter\Ci\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
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
        protected Environment $environment,
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
        return $this->environment->has(VarName::RequestID->value);
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
        [$projectId, $requestId] = [$this->getProjectId(), $this->getMergeRequestId()];

        return new Request('GET', $this->getGitlabServerUrl() . "/api/v4/projects/$projectId/merge_requests/$requestId/changes", [
            'PRIVATE-TOKEN' => [
                $this->credentials->getToken(),
            ],
        ]);
    }

    protected function getProjectId(): int
    {
        return $this->environment->getInt(VarName::ProjectID->value);
    }

    protected function getGitlabServerUrl(): string
    {
        return $this->environment->getString(VarName::ApiURL->value);
    }

    protected function getMergeRequestId(): int
    {
        return $this->environment->getInt(VarName::RequestID->value);
    }
}
