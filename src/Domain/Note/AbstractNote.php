<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

abstract class AbstractNote implements Note, \JsonSerializable
{
    protected const SEVERITY = NoteSeverity::Normal;

    public function getSeverity(): NoteSeverity
    {
        return static::SEVERITY;
    }

    public function __toString(): string
    {
        return $this->getDescription();
    }

    /**
     * @return array{severity: string, description: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'severity' => $this->getSeverity()->value,
            'description' => $this->getDescription(),
        ];
    }
}
