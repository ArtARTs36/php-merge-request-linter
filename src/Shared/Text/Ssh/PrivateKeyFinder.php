<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Text\Ssh;

use ArtARTs36\Str\Str;

final class PrivateKeyFinder implements SshKeyFinder
{
    private const REGEX = '/-----BEGIN ([A-Z\s]*) KEY-----\s+([a-zA-Z0-9\/+\s+]*)-----END ([A-Z\s]*) KEY-----/s';

    public function find(Str $text, bool $stopOnFirst): array
    {
        if ($stopOnFirst) {
            return [$text->match(self::REGEX)->toLower()->__toString()];
        }

        $types = [];

        $result = $text->globalMatch(self::REGEX);

        foreach ($result as $item) {
            if (is_array($item) && isset($item[1]) && is_string($item[1])) {
                $types[] = \ArtARTs36\Str\Facade\Str::toLower($item[1]);
            }
        }

        return $types;
    }
}
