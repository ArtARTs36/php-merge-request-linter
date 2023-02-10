<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

class NullEventDispatcher implements \Psr\EventDispatcher\EventDispatcherInterface
{
    public function dispatch(object $event): void
    {
        //
    }
}
