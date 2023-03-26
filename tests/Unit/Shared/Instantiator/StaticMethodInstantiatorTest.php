<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Instantiator;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Instantiator\StaticMethodInstantiator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class StaticMethodInstantiatorTest extends TestCase
{
    public function providerForTestConstruct(): array
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
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Instantiator\StaticMethodInstantiator::construct
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Instantiator\StaticMethodInstantiator::__construct
     * @dataProvider providerForTestConstruct
     */
    public function testConstruct(string $class, string $method, array $arts, array $expected): void
    {
        $constructor = new StaticMethodInstantiator((new \ReflectionClass($class))->getMethod($method), $class);

        self::assertSame($expected, get_object_vars($constructor->construct($arts)));
    }
}

class ClassForTestOfStaticConstructor implements Rule
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

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function lint(MergeRequest $request): array
    {
        // TODO: Implement lint() method.
    }

    public function getDefinition(): RuleDefinition
    {
        // TODO: Implement getDefinition() method.
    }
}

class Class2ForTestOfStaticConstructor implements Rule
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

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function lint(MergeRequest $request): array
    {
        // TODO: Implement lint() method.
    }

    public function getDefinition(): RuleDefinition
    {
        // TODO: Implement getDefinition() method.
    }
}
