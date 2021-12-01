<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\Credentials\GitlabCredentials;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\Str\Str;
use Gitlab\Client;

class GitlabCi extends AbstractCiSystem
{
    public function __construct(protected GitlabCredentials $credentials)
    {
        //
    }

    public function getMergeRequest(): MergeRequest
    {
        $request = $this->createClient()->mergeRequests()->show(
            $this->getProjectId(),
            $this->getMergeRequestId(),
        );

        return new MergeRequest(
            Str::make($request['title']),
            Str::make($request['description']),
            Map::fromList($request['labels']),
            $request['has_conflicts'] ?? false,
        );
    }

    protected function getProjectId(): int
    {
        return (int) $this->env('CI_MERGE_REQUEST_PROJECT_ID');
    }

    protected function getGitlabServerUrl(): string
    {
        return $this->env('CI_SERVER_URL');
    }

    protected function getMergeRequestId(): int
    {
        return (int) $this->env('CI_MERGE_REQUEST_IID');
    }

    protected function createClient(): Client
    {
        $client = new Client();
        $client->setUrl($this->getGitlabServerUrl());
        $client->authenticate($this->credentials->token, $this->credentials->method);

        return $client;
    }
}
