<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Linter;

use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\NullRegistry;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LinterFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory::__construct
     */
    public function testCreate(): void
    {
        $factory = new LinterFactory(
            new NullEventDispatcher(),
            new NullRegistry(),
        );

        $gotLinter = $factory->create($this->makeConfig([]));

        self::assertInstanceOf(Linter::class, $gotLinter);
    }
}
