<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Container;

use ArtARTs36\MergeRequestLinter\Infrastructure\Container\EntryNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MapContainerTest extends TestCase
{
    public function providerForTestGetOk(): array
    {
        return [
            [
                ClassForTestMapContainer::class,
                new ClassForTestMapContainer(),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::get
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::set
     * @dataProvider providerForTestGetOk
     */
    public function testGetOk(string $class, object $object): void
    {
        $container = new MapContainer();
        $container->set($class, $object);

        self::assertEquals($object, $container->get($class));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::get
     */
    public function testGetOnEntryNotFoundException(): void
    {
        $container = new MapContainer();

        self::expectException(EntryNotFoundException::class);

        $container->get('');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::get
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::bind
     */
    public function testGetOnBind(): void
    {
        $container = new MapContainer();

        $container->bind(ClassForTestMapContainer::class, static fn () => new ClassForTestMapContainer());

        self::assertInstanceOf(ClassForTestMapContainer::class, $container->get(ClassForTestMapContainer::class));
    }

    public function providerForTestHas(): array
    {
        return [
            [
                [
                    ClassForTestMapContainer::class => $c1 = new ClassForTestMapContainer(),
                ],
                ClassForTestMapContainer::class,
                true,
            ],
            [
                [],
                ClassForTestMapContainer::class,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::has
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::__construct
     * @param array<class-string, object> $initial
     * @param class-string $class
     * @dataProvider providerForTestHas
     */
    public function testHas(array $initial, string $class, bool $expected): void
    {
        $container = new MapContainer($initial);

        self::assertEquals($expected, $container->has($class));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::has
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer::bind
     */
    public function testHasOnBind(): void
    {
        $container = new MapContainer();

        $container->bind(ClassForTestMapContainer::class, static fn () => new ClassForTestMapContainer());

        self::assertTrue($container->has(ClassForTestMapContainer::class));
    }
}

class ClassForTestMapContainer
{
}
