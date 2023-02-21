<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Condition\Evaluator\Creator;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\Chain;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ChainFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ChainFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ChainFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ChainFactory::__construct
     */
    public function testCreate(): void
    {
        $factory = new ChainFactory(new ArrayMap([]), new SubjectFactory(new MockPropertyExtractor('')));

        self::assertInstanceOf(Chain::class, $factory->create());
    }
}
