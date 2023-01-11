<?php

namespace ArtARTs36\MergeRequestLinter\Support;

class Bytes
{
    /**
     * @var array<string,int>
     */
    private const SIZES = [
        'GB' => 1073741824,
        'MB' => 1048576,
        'KB' => 1024,
    ];

    public static function toString(int $bytes): string
    {
        foreach (self::SIZES as $unit => $value) {
            if ($bytes >= $value) {
                return sprintf('%.2f %s', $bytes / $value, $unit);
            }
        }

        return $bytes . ' byte' . ($bytes !== 1 ? 's' : '');
    }
}
