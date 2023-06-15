<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

class RawArray implements \IteratorAggregate
{
    /**
     * @param array<mixed> $value
     */
    public function __construct(
        private readonly array $value,
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
        $val = $this->value;
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
                'Value by path %s must be int',
                $path,
            ), $path, $path);
        }

        return $val;
    }

    public function stringOrNull(string $path): ?string
    {
        $val = $this->path($path);

        if (is_null($val)) {
            return null;
        }

        if (! is_string($val)) {
            throw new ArrayPathInvalidException(sprintf(
                'Value by path %s must be int',
                $path,
            ), $path, $path);
        }

        return $val;
    }

    public function bool(string $path): bool
    {
        $val = $this->path($path);

        if (! is_bool($val)) {
            throw new ArrayPathInvalidException(sprintf(
                'Value by path %s must be bool',
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

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->value);
    }
}
