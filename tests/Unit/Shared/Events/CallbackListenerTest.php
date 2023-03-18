<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Events;

use ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CallbackListenerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener::name
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener::__construct
     */
    public function testName(): void
    {
        $listener = new CallbackListener('test-listener', fn () => []);

        self::assertEquals('test-listener', $listener->name());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener::call
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener::__construct
     */
    public function testCall(): void
    {
        $callback = new class () {
            public int $called = 0;

            public function __invoke(): array
            {
                ++$this->called;

                return [];
            }
        };

        $listener = new CallbackListener('test-listener', \Closure::fromCallable($callback));

        $listener->call(new \stdClass());

        self::assertEquals(1, $callback->called);
    }
}
