<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Text\Ssh;

use ArtARTs36\Str\Str;

final class RsaKeyFinder implements SshKeyFinder
{
    private const REGEX = '/ssh-rsa AAAA[0-9A-Za-z+\/]+[=]{0,3} ([^@]+@[^@]+)/';

    public function findFirst(Str $text): ?string
    {
        return $this->stringHasSshKey($text) ? 'ssh-rsa' : null;
    }

    public function findAll(Str $text): array
    {
        return $this->stringHasSshKey($text) ? ['ssh-rsa'] : [];
    }

    private function stringHasSshKey(Str $text): bool
    {
        return $text->match(self::REGEX)->isNotEmpty() ;
    }
}
