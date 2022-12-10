<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

final class DefaultSystems
{
    public const MAP = [
        GithubActions::NAME => GithubActions::class,
        GitlabCi::NAME => GitlabCi::class,
    ];
}
