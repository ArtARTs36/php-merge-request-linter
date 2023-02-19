<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Chain;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\ChainFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ChainFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\ChainFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\ChainFactory::__construct
     */
    public function testCreate(): void
    {
        $factory = new ChainFactory(new ArrayMap([]), new SubjectFactory(new MockPropertyExtractor('')));

        self::assertInstanceOf(Chain::class, $factory->create());
    }
}
