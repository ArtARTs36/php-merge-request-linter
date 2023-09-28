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
        public string $placeholder = '',
    ) {
    }

    public function identity(): string
    {
        return sprintf('%s_%s', $this->category, $this->key);
    }

    /**
     * @param array<string, string> $labels
     */
    public function readableTitle(array $labels): string
    {
        if (Str::isEmpty($this->placeholder)) {
            return sprintf('[%s] %s', Str::upFirstSymbol($this->category), $this->title);
        }

        $replacesKeys = [];
        $replacesValues = [];

        foreach ($labels as $key => $value) {
            $replacesKeys[] = ':' . $key . ':';
            $replacesValues[] = $value;
        }

        return sprintf(
            '[%s] %s',
            Str::upFirstSymbol($this->category),
            str_replace($replacesKeys, $replacesValues, $this->placeholder),
        );
    }
}
