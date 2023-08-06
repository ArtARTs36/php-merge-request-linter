<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects;

enum PullRequestState: string
{
    case Unknown = 'UNKNOWN';
    case Open = 'OPEN';
    case Merged = 'MERGED';
    case Declined = 'DECLINED';
    case Superseded = 'SUPERSEDED';

    public static function create(string $state): self
    {
        return self::tryFrom($state) ?? self::Unknown;
    }
}
