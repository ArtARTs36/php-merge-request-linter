<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Type;

class Viewer
{
    public function __construct(
        public readonly string $login
    ) {
        //
    }
}
