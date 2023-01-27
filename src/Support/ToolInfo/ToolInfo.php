<?php

namespace ArtARTs36\MergeRequestLinter\Support\ToolInfo;

use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\Tag;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GithubClient;
use ArtARTs36\Str\Facade\Str;

class ToolInfo
{
    public const REPO_OWNER = 'artarts36';
    public const REPO_NAME = 'php-merge-request-linter';
    public const REPO_URI = 'https://github.com/ArtARTs36/php-merge-request-linter';

    private const PHAR_URI_PREFIX = 'phar://';

    public function __construct(
        private readonly GithubClient $github,
    ) {
        //
    }

    public function getLatestVersion(): ?Tag
    {
        return $this
            ->github
            ->getTags(new TagsInput(self::REPO_OWNER, self::REPO_NAME))
            ->sortByMajority()
            ->first();
    }

    public function usedAsPhar(): bool
    {
        return Str::startsWith(__DIR__, self::PHAR_URI_PREFIX);
    }
}
