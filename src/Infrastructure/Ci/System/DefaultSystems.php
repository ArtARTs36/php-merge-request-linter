<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;

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
