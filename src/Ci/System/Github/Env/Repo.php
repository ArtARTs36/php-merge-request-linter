<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Github\Env;

class Repo
{
    public function __construct(
        public readonly string $owner,
        public readonly string $name,
    ) {
        //
    }
}
