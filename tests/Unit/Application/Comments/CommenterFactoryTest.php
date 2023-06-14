<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\CommenterFactory;
use ArtARTs36\MergeRequestLinter\Application\Comments\NullCommenter;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCi;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockCiSystemFactory;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockOperatorResolver;
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
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\CommenterFactory::create
     *
     * @dataProvider providerForTestCreate
     */
    public function testCreate(CommentsPostStrategy $strategy, string $expectedClass): void
    {
        $factory = new CommenterFactory(
            new MockCiSystemFactory(new MockCi([
                'is_pull_request' => false,
            ])),
            new MockOperatorResolver(),
            TwigRenderer::create(),
            new NullLogger(),
        );

        self::assertInstanceOf($expectedClass, $factory->create($strategy));
    }
}
