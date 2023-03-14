<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

class Change implements \JsonSerializable
{
    /**
     * @param string $file
     */
    public function __construct(
        public readonly string $file,
        public readonly Diff $diff,
    ) {
        //
    }

    public function __toString(): string
    {
        return $this->file;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'file' => $this->file,
            'diff' => $this->diff->firsts(2)->mapToArray(fn (DiffLine $l): string => $l->content),
        ];
    }
}
