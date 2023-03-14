<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env;

/**
 * @codeCoverageIgnore
 */
class Repo
{
    public function __construct(
        public readonly string $workspace,
        public readonly string $slug,
    ) {
        //
    }
}
