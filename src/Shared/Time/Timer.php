<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

class Timer
{
    public function __construct(
        private readonly float $started,
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
