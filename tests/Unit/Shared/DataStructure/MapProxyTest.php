<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MapProxyTest extends TestCase
{
    public function providerForTestCallMethodWithForwardToMap(): array
    {
        return [
            ['count', [], 1],
            ['containsAny', [[1]], 1],
            ['contains', [1], 1],
            ['containsAll', [[1]], 1],
            ['getIterator', [], 1],
            ['get', [1], 1],
            ['isEmpty', [], 1],
            ['keys', [], 1],
            ['has', ['key'], 1],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy::count
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy::containsAny
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy::containsAll
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy::getIterator
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy::get
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy::isEmpty
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy::keys
     * @covers \ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy::has
     * @dataProvider providerForTestCallMethodWithForwardToMap
     */
    public function testCallMethodWithForwardToMap(string $methodName, array $args, int $expectedCalls): void
    {
        $counter = new CallsCounterMap();

        $proxy = new MapProxy(function () use ($counter) {
            return $counter;
        });

        call_user_func([$proxy, $methodName], ...$args);

        self::assertEquals($expectedCalls, $counter->counter, sprintf('Failed on method %s', $methodName));
    }
}
