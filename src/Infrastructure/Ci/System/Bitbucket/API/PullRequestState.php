<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

enum PullRequestState: string
{
    case Open = 'OPEN';
    case Merged = 'MERGED';
    case Declined = 'DECLINED';
    case Superseded = 'SUPERSEDED';
}
