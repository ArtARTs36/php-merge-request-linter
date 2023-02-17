<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

class MemoryCounter implements Counter
{
    public function __construct(
        private int $count = 0,
    ) {
        //
    }

    /**
     * @param \Countable|array $countable
     */
    public static function create(\Countable|array $countable): self
    {
        return new self(count($countable));
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
