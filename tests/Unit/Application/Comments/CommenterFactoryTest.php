<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\Factory;
use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\NewCommenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\NullCommenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\SingleCommenter;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Psr\Log\NullLogger;

final class CommenterFactoryTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            [
                CommentsPostStrategy::Null,
                NullCommenter::class,
            ],
            [
                CommentsPostStrategy::New,
                NewCommenter::class,
            ],
            [
                CommentsPostStrategy::Single,
                SingleCommenter::class,
            ],
            [
                CommentsPostStrategy::SingleAppend,
                SingleCommenter::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\Factory::create
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\Factory::__construct
     *
     * @dataProvider providerForTestCreate
     */
    public function testCreate(CommentsPostStrategy $strategy, string $expectedClass): void
    {
        $factory = new Factory(
            new MockCiSystemFactory(new MockCi([
                'is_pull_request' => false,
            ])),
            new NullLogger(),
        );

        self::assertInstanceOf($expectedClass, $factory->create($strategy));
    }
}
