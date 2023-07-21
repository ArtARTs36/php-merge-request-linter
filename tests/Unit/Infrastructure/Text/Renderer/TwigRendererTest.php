<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Text\Renderer;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextRenderingFailedException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
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

        self::assertEquals($expected, $renderer->render($text, $data));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer::render
     */
    public function testRenderOnExceptionOnTwigSyntaxError(): void
    {
        $renderer = TwigRenderer::create();

        try {
            $renderer->render('{{ $.sd }}', []);

            self::fail('TwigRender not throws invalid template exception');
        } catch (TextRenderingFailedException $e) {
            self::assertStringStartsWith('invalid template: ', $e->getMessage());
        }
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer::render
     */
    public function testRenderOnExceptionOnTypeError(): void
    {
        $renderer = TwigRenderer::create();

        self::expectExceptionMessage('Unsupported operand types: int + string');

        $renderer->render('{{ var1 + var2 }}', [
            'var1' => 12,
            'var2' => 'dddsdwsds',
        ]);
    }
}
