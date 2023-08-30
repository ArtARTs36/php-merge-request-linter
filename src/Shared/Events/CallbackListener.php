<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Events;

final readonly class CallbackListener implements EventListener
{
    /**
     * @template E of object
     * @param \Closure(E): void $callback
     */
    public function __construct(
        private string   $name,
        private \Closure $callback,
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
