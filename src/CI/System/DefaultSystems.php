<?php

namespace ArtARTs36\MergeRequestLinter\CI\System;

use ArtARTs36\MergeRequestLinter\CI\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

final class DefaultSystems
{
    /** @var array<string, class-string<CiSystem>> */
    public static array $map = [
        GithubActions::NAME => GithubActions::class,
        GitlabCi::NAME => GitlabCi::class,
    ];

    /**
     * @return ArrayMap<string, class-string<CiSystem>>
     */
    public static function map(): ArrayMap
    {
        return new ArrayMap(self::$map);
    }

    private function __construct()
    {
        //
    }
}
