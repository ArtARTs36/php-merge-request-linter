<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystem;

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
        return new ArrayMap(self::$map);
    }

    private function __construct()
    {
        //
    }
}
