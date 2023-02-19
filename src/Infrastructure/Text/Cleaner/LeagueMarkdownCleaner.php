<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\Str\Str;
use League\CommonMark\ConverterInterface;

class LeagueMarkdownCleaner implements MarkdownCleaner
{
    public function __construct(
        private readonly ConverterInterface $converter,
    ) {
        //
    }

    public function clean(string|Str $str): Str
    {
        $html = $this->converter->convert($str)->getContent();

        return Str::make(strip_tags($html));
    }
}
