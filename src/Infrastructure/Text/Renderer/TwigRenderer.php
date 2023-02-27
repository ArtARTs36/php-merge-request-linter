<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use Twig\Environment;
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
        $templateName = time();

        $this->loader->setTemplate($templateName, $text);

        return $this->environment->render($templateName, $data->toArray());
    }
}
