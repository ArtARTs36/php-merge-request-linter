<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Github\Env;

use ArtARTs36\Str\Facade\Str;

class Repo
{
    private const SEPARATOR = '/';

    public function __construct(
        public readonly string $owner,
        public readonly string $name,
    ) {
        //
    }

    public static function createFromString(string $repo): self
    {
        [$owner, $name] = Str::explode($repo, self::SEPARATOR);

        return new self($owner, $name);
    }
}
