<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag;

class TagsInput
{
    public function __construct(
        public readonly string $owner,
        public readonly string $repo,
    ) {
        //
    }
}
