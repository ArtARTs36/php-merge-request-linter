<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;

final class WarningNote implements Note, \JsonSerializable
{
    public function __construct(
        private readonly string $description,
    ) {
        //
    }

    public function jsonSerialize(): mixed
    {
        return [
            'description' => $this->getDescription(),
        ];
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSeverity(): NoteSeverity
    {
        return NoteSeverity::Warning;
    }

    public function __toString(): string
    {
        return $this->description;
    }

    public function withSeverity(NoteSeverity $severity): Note
    {
        return $this;
    }
}
