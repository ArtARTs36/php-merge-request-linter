<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env;

/**
 * @codeCoverageIgnore
 */
readonly class Repo
{
    public function __construct(
        public string $workspace,
        public string $slug,
    ) {
        //
    }
}
