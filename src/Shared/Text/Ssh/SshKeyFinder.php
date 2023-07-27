<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Text\Ssh;

use ArtARTs36\Str\Str;

interface SshKeyFinder
{
    /**
     * @return list<string> key types
     */
    public function find(Str $text, bool $stopOnFirst): array;
}
