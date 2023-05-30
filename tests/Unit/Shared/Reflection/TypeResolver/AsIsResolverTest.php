<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AsIsResolverTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\AsIsResolver::resolve
     */
    public function testResolve(): void
    {
        $resolver = new AsIsResolver();

        self::assertEquals('value', $resolver->resolve(new Type(TypeName::String), 'value'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\AsIsResolver::canResolve
     */
    public function testCanResolve(): void
    {
        $resolver = new AsIsResolver();

        self::assertTrue($resolver->canResolve(new Type(TypeName::String), 'value'));
    }
}
