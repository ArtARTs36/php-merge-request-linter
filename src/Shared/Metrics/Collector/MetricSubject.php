<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

use ArtARTs36\Str\Facade\Str;

/**
 * @codeCoverageIgnore
 */
readonly class MetricSubject
{
    public function __construct(
        public string $category,
        public string $key,
        public string $title,
    ) {
    }

    public function identity(): string
    {
        return sprintf('%s_%s', $this->category, $this->key);
    }

    public function wrapTitle(): string
    {
        return sprintf('[%s] %s', Str::upFirstSymbol($this->category), $this->title);
    }
}
