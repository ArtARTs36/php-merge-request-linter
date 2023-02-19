<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\Str\Str;

final class MockMarkdownCleaner implements MarkdownCleaner
{
    public function clean(string|Str $str): Str
    {
        return $str instanceof Str ? $str : Str::make($str);
    }
}
