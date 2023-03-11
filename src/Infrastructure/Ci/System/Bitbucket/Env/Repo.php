<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env;

class Repo
{
    public function __construct(
        public readonly string $projectKey,
        public readonly string $slug,
    ) {
        //
    }
}
