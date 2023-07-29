<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Text\Ssh;

use ArtARTs36\Str\Str;

/**
 * Interface for SshKeyFinder.
 * @phpstan-type SshKeyType = string
 */
interface SshKeyFinder
{
    /**
     * Find first ssh key type.
     * @return SshKeyType|null
     */
    public function findFirst(Str $text): ?string;

    /**
     * Find all ssh key types.
     * @return list<SshKeyType> key types
     */
    public function findAll(Str $text): array;
}
