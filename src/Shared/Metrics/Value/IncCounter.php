<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

class IncCounter implements Counter
{
    public function __construct(
        private int $count = 0,
    ) {
        //
    }

    /**
     * @param \Countable|array<mixed> $countable
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
