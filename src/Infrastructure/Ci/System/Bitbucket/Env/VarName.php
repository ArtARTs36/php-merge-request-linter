<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env;

enum VarName: string
{
    case PipelinesToken = 'PIPELINES_JWT_TOKEN';
    case ProjectKey = 'BITBUCKET_PROJECT_KEY';
    case PullRequestId = 'BITBUCKET_PR_ID';
    case RepoName = 'BITBUCKET_REPO_SLUG';
    case HttpOrigin = 'BITBUCKET_GIT_HTTP_ORIGIN';
    case Workspace = 'BITBUCKET_WORKSPACE';
}
