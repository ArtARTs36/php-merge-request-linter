<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\DateTimeResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DateTimeResolverTest extends TestCase
{
    public function providerForTestCanResolve(): array
    {
        return [
            [
                new Type(TypeName::Object),
                '',
                false,
            ],
            [
                new Type(TypeName::Object, \DateTime::class),
                '',
                true,
            ],
            [
                new Type(TypeName::Object, \DateTimeImmutable::class),
                '',
                true,
            ],
            [
                new Type(TypeName::Object, \DateTimeInterface::class),
                '',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\DateTimeResolver::canResolve
     * @dataProvider providerForTestCanResolve
     */
    public function testCanResolve(Type $type, mixed $value, bool $expected): void
    {
        $resolver = new DateTimeResolver();

        self::assertEquals($expected, $resolver->canResolve($type, $value));
    }

    public function providerForTestResolveOnException(): array
    {
        return [
            [
                new Type(TypeName::Object),
                null,
                'Arg with type NULL not supported. Expected type: string of date',
            ],
            [
                new Type(TypeName::Object, \DateTime::class),
                null,
                'Arg with type NULL not supported. Expected type: string of date',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\DateTimeResolver::resolve
     * @dataProvider providerForTestResolveOnException
     */
    public function testResolveOnException(Type $type, mixed $value, string $exception): void
    {
        $resolver = new DateTimeResolver();

        self::expectExceptionMessage($exception);

        $resolver->resolve($type, $value);
    }

    public function providerForTestResolve(): array
    {
        return [
            [
                new Type(TypeName::Object, \DateTime::class),
                '10-10-2010',
                new \DateTime('10-10-2010'),
            ],
            [
                new Type(TypeName::Object, \DateTimeImmutable::class),
                '10-10-2010',
                new \DateTimeImmutable('10-10-2010'),
            ],
            [
                new Type(TypeName::Object, \DateTimeInterface::class),
                '10-10-2010',
                new \DateTimeImmutable('10-10-2010'),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\DateTimeResolver::resolve
     * @dataProvider providerForTestResolve
     */
    public function testResolve(Type $type, mixed $value, \DateTimeInterface $expected): void
    {
        $resolver = new DateTimeResolver();

        self::assertEquals($expected, $resolver->resolve($type, $value));
    }
}
