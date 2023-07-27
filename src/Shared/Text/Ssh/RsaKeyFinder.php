<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Text\Ssh;

use ArtARTs36\Str\Str;

final class RsaKeyFinder implements SshKeyFinder
{
    private const REGEX = '/ssh-rsa AAAA[0-9A-Za-z+\/]+[=]{0,3} ([^@]+@[^@]+)/';

    public function find(Str $text, bool $stopOnFirst): array
    {
        return $text->match(self::REGEX)->isNotEmpty() ? ['ssh-rsa'] : [];
    }
}
