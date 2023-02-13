<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

class MemoryCounter implements Counter
{
    public function __construct(
        private int $count = 0,
    ) {
        //
    }

    public static function create(\Countable $countable): self
    {
        return new self($countable->count());
    }

    public function inc(): void
    {
        ++$this->count;
    }

    public function getMetricValue(): string
    {
        return "$this->count";
    }
}
