<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextRenderingFailedException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\ArrayLoader;

class TwigRenderer implements TextRenderer
{
    public function __construct(
        private readonly Environment $environment,
        private readonly ArrayLoader $loader,
    ) {
        //
    }

    public static function create(): self
    {
        $loader = new ArrayLoader();

        return new self(new Environment($loader), $loader);
    }

    public function render(string $text, Map $data): string
    {
        $templateName = 'template_' . time();

        $this->loader->setTemplate($templateName, $text);

        try {
            return $this->environment->render($templateName, $data->toArray());
        } catch (SyntaxError $e) {
            throw new TextRenderingFailedException(
                sprintf('invalid template: %s', $e->getMessage()),
                previous: $e,
            );
        } catch (LoaderError|RuntimeError $e) {
            throw new TextRenderingFailedException($e->getMessage(), previous: $e);
        }
    }
}
