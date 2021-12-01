<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\Credentials\GitlabCredentials;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\Str\Str;
use Gitlab\Client;

class GitlabCi extends AbstractCiSystem
{
    public function __construct(protected GitlabCredentials $credentials, protected Environment $environment)
    {
        //
    }

    public function getMergeRequest(): MergeRequest
    {
        [$projectId, $requestId] = [$this->getProjectId(), $this->getMergeRequestId()];

        try {
            $request = $this->createClient()->mergeRequests()->show($projectId, $requestId);
        } catch (\Throwable $e) {
            throw new InvalidCredentialsException(previous: $e);
        }

        return new MergeRequest(
            Str::make($request['title']),
            Str::make($request['description']),
            Map::fromList($request['labels']),
            $request['has_conflicts'] ?? false,
        );
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
        $client->authenticate($this->credentials->getToken(), $this->credentials->method);

        return $client;
    }
}
