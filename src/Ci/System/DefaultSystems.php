<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

final class DefaultSystems
{
    /** @var array<string, class-string<CiSystem>> */
    public static array $map = [
        GithubActions::NAME => GithubActions::class,
        GitlabCi::NAME => GitlabCi::class,
    ];

    /**
     * @return Map<string, class-string<CiSystem>>
     */
    public static function map(): Map
    {
        return new Map(self::$map);
    }

    private function __construct()
    {
        //
    }
}
