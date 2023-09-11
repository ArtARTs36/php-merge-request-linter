<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

readonly class Change implements \JsonSerializable
{
    /**
     * @param string $file
     */
    public function __construct(
        public string $file,
        public Diff   $diff,
    ) {
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
            'diff' => $this->diff->allFragments->firsts(2)->mapToArray(fn (DiffFragment $f): string => $f->content),
        ];
    }

    public function fileExtension(): string
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }
}
