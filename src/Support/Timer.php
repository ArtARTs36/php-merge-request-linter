<?php

namespace ArtARTs36\MergeRequestLinter\Support;

class Timer
{
    protected ?float $finish;

    protected ?float $duration;

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
        $this->finish = microtime(true);

        return $this->duration = $this->finish - $this->started;
    }
}
