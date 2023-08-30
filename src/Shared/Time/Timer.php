<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

readonly class Timer
{
    public function __construct(
        private float $started,
    ) {
        //
    }

    public static function start(): self
    {
        return new self(microtime(true));
    }

    public function finish(): Duration
    {
        return new Duration(microtime(true) - $this->started);
    }
}
