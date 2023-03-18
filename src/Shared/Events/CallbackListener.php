<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Events;

final class CallbackListener implements EventListener
{
    /**
     * @template E of object
     * @param \Closure(E): void $callback
     */
    public function __construct(
        private readonly string $name,
        private readonly \Closure $callback,
    ) {
        //
    }

    public function name(): string
    {
        return $this->name;
    }

    public function call(object $event): void
    {
        ($this->callback)($event);
    }
}
