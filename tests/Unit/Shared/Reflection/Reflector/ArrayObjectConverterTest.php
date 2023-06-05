<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\Reflector;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayObjectConverter;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockTypeResolver;
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
                    'stack' => 'php',
                    'company' => new TestCompany(null),
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
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayObjectConverter::convert
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayObjectConverter::mapParams
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayObjectConverter::__construct
     * @dataProvider providerForTestConvert
     */
    public function testConvert(array $data, string $class, array $expect): void
    {
        $converter = new ArrayObjectConverter(new AsIsResolver());

        $result = $converter->convert($data, $class);

        self::assertInstanceOf($class, $result);
        self::assertEquals($expect, get_object_vars($result));
    }

    public function providerForTestConvertOnPropertyIsMissing(): array
    {
        return [
            [
                [],
                TestPeople::class,
                'Required parameter "name" is missing',
            ],
            [
                [],
                ClassWithParamExample::class,
                'Required parameter "name" is missing. Example values: ["Example name"]',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ArrayObjectConverter::convert
     * @dataProvider providerForTestConvertOnPropertyIsMissing
     */
    public function testConvertOnPropertyIsMissing(array $data, string $class, string $expectedException): void
    {
        $converter = new ArrayObjectConverter(new MockTypeResolver());

        self::expectExceptionMessage($expectedException);

        $converter->convert($data, $class);
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
        public readonly TestCompany $company,
        public readonly string $stack = 'php',
    ) {
        //
    }
}

class TestCompany
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name = 'google',
    ) {
    }
}

class ClassWithParamExample
{
    public function __construct(
        #[Example('Example name')]
        public readonly string $name,
    ) {
        //
    }
}
