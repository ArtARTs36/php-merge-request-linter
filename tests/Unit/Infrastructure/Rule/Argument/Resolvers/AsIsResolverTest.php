<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\AsIsResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class AsIsResolverTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\AsIsResolver::resolve
     */
    public function testResolve(): void
    {
        $resolver = new AsIsResolver();

        self::assertEquals('value', $resolver->resolve(new Type(TypeName::String), 'value'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers\AsIsResolver::canResolve
     */
    public function testCanResolve(): void
    {
        $resolver = new AsIsResolver();

        self::assertTrue($resolver->canResolve(new Type(TypeName::String), 'value'));
    }
}
