<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag;

class Tag
{
    public function __construct(
        public readonly string $version,
        public readonly int $major,
        public readonly int $minor,
        public readonly int $patch,
    ) {
        //
    }

    public function digit(): string
    {
        return sprintf('%d.%d.%d', $this->major, $this->minor, $this->patch);
    }
}
