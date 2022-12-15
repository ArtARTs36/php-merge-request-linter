<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
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
        return $environment->has('GITLAB_CI');
    }

    public function isMergeRequest(): bool
    {
        return $this->environment->has('CI_MERGE_REQUEST_IID');
    }

    public function getMergeRequest(): MergeRequest
    {
        $response = $this->client->sendRequest($this->makeHttpRequestForFetchMergeRequest());

        $this->validateResponse($response, self::NAME);

        $responseArray = $this->responseToJsonArray($response);
        $responseArray['changed_files_count'] = count($responseArray['changes']);
        $responseArray['author_login'] = $responseArray['author']['username'];

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
        return $this->environment->getInt('CI_MERGE_REQUEST_PROJECT_ID');
    }

    protected function getGitlabServerUrl(): string
    {
        return $this->environment->getString('CI_SERVER_URL');
    }

    protected function getMergeRequestId(): int
    {
        return $this->environment->getInt('CI_MERGE_REQUEST_IID');
    }
}
