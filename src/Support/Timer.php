<?php

namespace ArtARTs36\MergeRequestLinter\Support;

class Timer
{
    protected float $finish;

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
        return $this->finish = microtime(true) - $this->started;
    }
}
