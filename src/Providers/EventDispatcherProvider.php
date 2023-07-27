<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventDispatcher;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use Psr\EventDispatcher\EventDispatcherInterface;

final class EventDispatcherProvider extends Provider
{
    public function provide(): void
    {
        $ed = new EventDispatcher($this->container->get(ContextLogger::class));

        $this->container->set(EventDispatcher::class, $ed);
        $this->container->set(EventManager::class, $ed);
        $this->container->set(EventDispatcherInterface::class, $ed);
    }
}
