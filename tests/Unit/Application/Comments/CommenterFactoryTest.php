<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\CommenterFactory;
use ArtARTs36\MergeRequestLinter\Application\Comments\NullCommenter;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CommenterFactoryTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            [
                CommentsPostStrategy::Null,
                NullCommenter::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\CommenterFactory::create
     *
     * @dataProvider providerForTestCreate
     */
    public function testCreate(CommentsPostStrategy $strategy, string $expectedClass): void
    {
        $factory = new CommenterFactory();

        self::assertInstanceOf($expectedClass, $factory->create($strategy));
    }
}
