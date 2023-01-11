<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag;

class TagsInput
{
    public function __construct(
        public readonly string $owner,
        public readonly string $repo,
    ) {
        //
    }
}
