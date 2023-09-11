<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\Tag;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\Str\Facade\Str;

class ToolInfo implements \ArtARTs36\MergeRequestLinter\Domain\ToolInfo\ToolInfo
{
    public const REPO_OWNER = 'artarts36';
    public const REPO_NAME = 'php-merge-request-linter';
    public const REPO_URI = 'https://github.com/ArtARTs36/php-merge-request-linter';

    private const PHAR_URI_PREFIX = 'phar://';

    public function __construct(
        private readonly GithubClient $github,
        private readonly string $dir = __DIR__
    ) {
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
        return Str::startsWith($this->dir, self::PHAR_URI_PREFIX);
    }
}
