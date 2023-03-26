<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Instantiator;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Instantiator\NativeConstructorInstantiator;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NativeConstructorInstantiatorTest extends TestCase
{
    public function providerForTestConstruct(): array
    {
        return [
            [
                NativeConstructorTestObject1::class,
                [
                    'prop1' => '1',
                    'prop4' => 4.0,
                    'prop2' => 2,
                    'prop3' => 3,
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Instantiator\NativeConstructorInstantiator::construct
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Instantiator\NativeConstructorInstantiator::__construct
     * @dataProvider providerForTestConstruct
     */
    public function testConstruct(string $class, array $args): void
    {
        $constructor = new NativeConstructorInstantiator(
            $rc = new \ReflectionClass($class),
            $rc->getConstructor(),
        );

        $givenObject = $constructor->construct($args);

        self::assertInstanceOf($class, $givenObject);
        self::assertEquals($args, get_object_vars($givenObject));
    }
}

class NativeConstructorTestObject1 implements Rule
{
    public function __construct(
        public string $prop1,
        public int $prop2,
        public int $prop3,
        public float $prop4,
    ) {
        //
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
