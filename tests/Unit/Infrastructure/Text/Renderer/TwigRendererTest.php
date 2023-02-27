<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Text\Renderer;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TwigRendererTest extends TestCase
{
    public function providerForTestRender(): array
    {
        return [
            [
                'text' => 'Hello, {{ name }}!',
                'data' => [
                    'name' => 'Dev',
                ],
                'expected' => 'Hello, Dev!',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer::render
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer::__construct
     * @dataProvider providerForTestRender
     */
    public function testRender(string $text, array $data, string $expected): void
    {
        $renderer = TwigRenderer::create();

        self::assertEquals($expected, $renderer->render($text, new ArrayMap($data)));
    }
}
