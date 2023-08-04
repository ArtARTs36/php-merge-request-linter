<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Type;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ViewerTest extends TestCase
{
    public function providerForTestMake(): array
    {
        return [
            [
                'test',
                'test',
            ],
            [
                'github-actions[bot]',
                'github-actions',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer::make
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer::__construct
     *
     * @dataProvider providerForTestMake
     */
    public function testMake(string $inputLogin, string $expectedLogin): void
    {
        $viewer = Viewer::make($inputLogin);

        self::assertEquals(
            $expectedLogin,
            $viewer->login,
        );
    }
}
