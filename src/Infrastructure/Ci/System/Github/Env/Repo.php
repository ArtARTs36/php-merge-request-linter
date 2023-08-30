<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env;

/**
 * @codeCoverageIgnore
 */
readonly class Repo
{
    public function __construct(
        public string $owner,
        public string $name,
    ) {
        //
    }
}
