<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway;

/**
 * @codeCoverageIgnore
 */
readonly class Metric
{
    /**
     * @param array<string, int|string> $labels
     */
    public function __construct(
        public string $type,
        public string $key,
        public string $help,
        public array $labels,
        public int|string|float $value,
    ) {
    }

    /**
     * @param array<string, int|string> $labels
     */
    public static function gauge(string $key, string $help, array $labels, int|string|float $value): self
    {
        return new self('gauge', $key, $help, $labels, $value);
    }
}
