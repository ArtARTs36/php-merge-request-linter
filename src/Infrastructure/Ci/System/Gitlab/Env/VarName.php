<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env;

enum VarName: string
{
    case Identity = 'GITLAB_CI';
    case RequestID = 'CI_MERGE_REQUEST_IID';
    case ProjectID = 'CI_MERGE_REQUEST_PROJECT_ID';
    case ApiURL = 'CI_SERVER_URL';
}
