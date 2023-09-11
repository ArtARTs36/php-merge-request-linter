<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule;

use ArtARTs36\MergeRequestLinter\Shared\Text\Markdown\HeadingLevel;
use ArtARTs36\Str\Markdown\MarkdownList;
use ArtARTs36\Str\MarkdownHeading;
use ArtARTs36\Str\Str;

class ReleaseParser
{
    private const TAG_REGEX = '/(v?[0-9]+.[0-9]+.[0-9]+)(\-(\w+))?/i';

    /**
     * @return array<Release>
     * @throws \ArtARTs36\Str\Exceptions\InvalidRegexException
     */
    public function parse(Str $str): array
    {
        $releases = [];

        $currentRelease = null;

        $elements = $str->markdown()->elements(true);
        $elementsLen = count($elements);

        for ($i = 0; $i < $elementsLen; $i++) {
            $elem = $elements[$i];

            if (! $elem instanceof MarkdownHeading) {
                continue;
            }

            if ($elem->level === HeadingLevel::Level2->value) {
                $elemTag = $elem->title->match(self::TAG_REGEX);

                if ($elemTag->isEmpty()) {
                    continue;
                }

                if ($currentRelease !== null) {
                    $releases[] = $this->createRelease($currentRelease);
                }

                $title = $elem->title;
                $tag = $elemTag;
                $currentRelease = [
                    'title' => $title,
                    'tag' => $tag,
                    'changes' => [],
                ];

                continue;
            }

            if ($currentRelease !== null && $elem->level === HeadingLevel::Level3->value) {
                $changeType = (string) $elem->title;

                $currentRelease['changes'][$changeType] = [];

                if (isset($elements[$i + 1]) && $elements[$i + 1] instanceof MarkdownList) {
                    $markdownList = $elements[$i + 1];

                    foreach ($markdownList->items as $item) {
                        $currentRelease['changes'][$changeType][] = $item->content();
                    }
                }
            }
        }

        if ($currentRelease !== null) {
            $releases[] = $this->createRelease($currentRelease);
        }

        return $releases;
    }

    /**
     * @return array<string>
     */
    public function parseTags(Str $str): array
    {
        $headings = $str->markdown()->headings()->filterByLevel(HeadingLevel::Level2->value);
        $tags = [];

        foreach ($headings as $heading) {
            $tag = $heading->title->match(self::TAG_REGEX);

            if ($tag->isNotEmpty()) {
                $tags[] = (string) $tag;
            }
        }

        return $tags;
    }

    /**
     * @param array{
     *     title: Str,
     *     tag: Str,
     *     changes: array<string, array<Str>>,
     * } $releaseData
     */
    private function createRelease(array $releaseData): Release
    {
        $releaseChanges = [];

        foreach ($releaseData['changes'] as $changeType => $changes) {
            $releaseChanges[] = new ReleaseChanges($changeType, $changes);
        }

        return new Release(
            $releaseData['title'],
            $releaseData['tag'],
            $releaseChanges,
        );
    }
}
