<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use Gitlab\Client;

class GitlabCi implements CiSystem
{
    public function __construct(protected RemoteCredentials $credentials, protected Environment $environment)
    {
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
        [$projectId, $requestId] = [$this->getProjectId(), $this->getMergeRequestId()];

        try {
            $request = $this->createClient()->mergeRequests()->show($projectId, $requestId);
        } catch (\Throwable $e) {
            throw new InvalidCredentialsException(previous: $e);
        }

        return MergeRequest::fromArray($request);
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

    protected function createClient(): Client
    {
        $client = new Client();
        $client->setUrl($this->getGitlabServerUrl());
        $client->authenticate($this->credentials->getToken(), Client::AUTH_HTTP_TOKEN);

        return $client;
    }
}
