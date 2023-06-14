<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

class Arr
{
    public static function path(array $array, string $path, string $separator = '.'): mixed
    {
        $val = $array;
        $currPath = '';

        foreach (explode($separator, $path) as $part) {
            $currPath .= $part;

            if (! is_array($val)) {
                throw new ArrayPathInvalidException(sprintf(
                    'Value by path %s must be array',
                    $part,
                ), $part, $currPath);
            }

            if (! array_key_exists($part, $val)) {
                throw new ArrayPathInvalidException(sprintf(
                    'Array doesnt have path %s',
                    $part,
                ), $part, $currPath);
            }

            $val = $val[$part];
        }

        return $val;
    }
}
