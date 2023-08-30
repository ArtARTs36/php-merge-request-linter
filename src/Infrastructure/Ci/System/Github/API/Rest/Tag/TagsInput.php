<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag;

/**
 * @codeCoverageIgnore
 */
readonly class TagsInput
{
    public function __construct(
        public string $owner,
        public string $repo,
    ) {
        //
    }
}
