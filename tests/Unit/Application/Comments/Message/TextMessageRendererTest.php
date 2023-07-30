<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Message\TextMessageRenderer;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockTextRenderer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TextMessageRendererTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Message\TextMessageRenderer::render
     * @covers \ArtARTs36\MergeRequestLinter\Application\Comments\Message\TextMessageRenderer::__construct
     */
    public function testRender(): void
    {
        $renderer = new TextMessageRenderer(new MockTextRenderer('test'));

        self::assertEquals('test', $renderer->render(
            $this->makeMergeRequest(),
            $this->makeSuccessLintResult(),
            new CommentsMessage('', []),
        ));
    }
}
