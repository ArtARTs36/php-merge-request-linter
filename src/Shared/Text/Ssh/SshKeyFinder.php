<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Text\Ssh;

use ArtARTs36\Str\Str;

/**
 * @phpstan-type SshKeyType = string
 */
interface SshKeyFinder
{
    /**
     * @return SshKeyType|null
     */
    public function findFirst(Str $text): ?string;

    /**
     * @return list<SshKeyType> key types
     */
    public function findAll(Str $text): array;
}
