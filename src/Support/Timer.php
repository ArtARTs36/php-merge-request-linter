<?php

namespace ArtARTs36\MergeRequestLinter\Support;

class Timer
{
    public function __construct(protected float $started)
    {
        //
    }

    public static function start(): self
    {
        return new self(microtime(true));
    }

    public function finish(): float
    {
        return microtime(true) - $this->started;
    }
}
