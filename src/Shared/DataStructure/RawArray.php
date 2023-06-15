<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

class RawArray
{
    /**
     * @param array<mixed> $array
     */
    public function __construct(
        public readonly array $array,
    ) {
        //
    }

    /**
     * @param array<mixed> $array
     * @param non-empty-string $separator
     * @throws ArrayPathInvalidException
     */
    public function path(string $path): mixed
    {
        $val = $this->array;
        $currPath = '';

        foreach (explode('.', $path) as $part) {
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

    /**
     * @return array<mixed>
     */
    public function array(string $path): RawArray
    {
        $val = $this->path($path);

        if (! is_array($val)) {
            throw new ArrayPathInvalidException(sprintf(
                'Value by path %s must be array',
                $path,
            ), $path, $path);
        }

        return new RawArray($val);
    }

    public function string(string $path): string
    {
        $val = $this->path($path);

        if (! is_string($val)) {
            throw new ArrayPathInvalidException(sprintf(
                'Value by path %s must be string',
                $path,
            ), $path, $path);
        }

        return $val;
    }

    public function int(string $path): int
    {
        $val = $this->path($path);

        if (! is_int($val)) {
            throw new ArrayPathInvalidException(sprintf(
                'Value by path %s must be string',
                $path,
            ), $path, $path);
        }

        return $val;
    }
}
