<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\StaticMethodInstantiator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class StaticMethodInstantiatorTest extends TestCase
{
    public function providerForTestInstantiate(): array
    {
        return [
            [
                ClassForTestOfStaticConstructor::class,
                'make',
                [
                    'name' => 'John',
                    'age' => 20,
                    'isDeveloper' => true,
                ],
                [
                    'name' => 'John',
                    'age' => 20,
                    'isDeveloper' => true,
                ],
            ],
            [
                Class2ForTestOfStaticConstructor::class,
                'make',
                [
                    'name' => 'John',
                    'age' => 20,
                    'isDeveloper' => true,
                ],
                [
                    'name' => 'John-suffix',
                    'age' => 21,
                    'isDeveloper' => true,
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\StaticMethodInstantiator::instantiate
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\StaticMethodInstantiator::__construct
     * @dataProvider providerForTestInstantiate
     */
    public function testInstantiate(string $class, string $method, array $arts, array $expected): void
    {
        $constructor = new StaticMethodInstantiator((new \ReflectionClass($class))->getMethod($method), $class);

        self::assertSame($expected, get_object_vars($constructor->instantiate($arts)));
    }
}

class ClassForTestOfStaticConstructor
{
    public function __construct(
        public readonly string $name,
        public readonly int $age,
        public readonly bool $isDeveloper,
    ) {
        //
    }

    public static function make(
        string $name,
        int $age,
        bool $isDeveloper,
    ): self {
        return new self($name, $age, $isDeveloper);
    }
}

class Class2ForTestOfStaticConstructor
{
    public function __construct(
        public readonly string $name,
        public readonly int $age,
        public readonly bool $isDeveloper,
    ) {
        //
    }

    public static function make(
        string $name,
        int $age,
        bool $isDeveloper,
    ): self {
        return new self($name . '-suffix', $age + 1, $isDeveloper);
    }
}
