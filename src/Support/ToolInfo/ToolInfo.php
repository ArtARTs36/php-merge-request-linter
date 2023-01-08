<?php

namespace ArtARTs36\MergeRequestLinter\Support\ToolInfo;

use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\Tag;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GithubClient;
use ArtARTs36\Str\Facade\Str;

class ToolInfo
{
    public function __construct(
        private readonly GithubClient $github,
    ) {
        //
    }

    public function getLatestVersion(): ?Tag
    {
        $versions = $this->github->getTags(new TagsInput('artarts36', 'php-merge-request-linter'));

        return $versions->sortByMajority()->first();
    }

    public function usedAsPhar(): bool
    {
        return Str::startsWith(__DIR__, 'phar://');
    }
}
