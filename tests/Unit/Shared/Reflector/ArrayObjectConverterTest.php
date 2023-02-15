<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflector;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ArrayObjectConverterTest extends TestCase
{
    public function providerForTestConvert(): array
    {
        return [
            [
                [
                    'name' => 'Ivan',
                    'age' => 20,
                    'isProgrammer' => true,
                ],
                TestPeople::class,
                [
                    'name' => 'Ivan',
                    'age' => 20,
                    'isProgrammer' => true,
                    'phone' => null,
                ],
            ],
            [
                [],
                WithoutConstructorClass::class,
                [],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflector\ArrayObjectConverter::convert
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflector\ArrayObjectConverter::mapParams
     * @dataProvider providerForTestConvert
     */
    public function testConvert(array $data, string $class, array $expect): void
    {
        $converter = new ArrayObjectConverter();

        $result = $converter->convert($data, $class);

        self::assertInstanceOf($class, $result);
        self::assertEquals($expect, get_object_vars($result));
    }
}

class WithoutConstructorClass
{
    //
}

class TestPeople
{
    public function __construct(
        public readonly string $name,
        public readonly int $age,
        public readonly bool $isProgrammer,
        public readonly ?string $phone,
    ) {
        //
    }
}
