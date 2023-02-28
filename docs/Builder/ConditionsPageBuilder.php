<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\OperatorMetadataLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class ConditionsPageBuilder
{
    public function __construct(
        private readonly OperatorMetadataLoader $metadataLoader = new OperatorMetadataLoader(),
    ) {
        //
    }

    public function build(): string
    {
        $operators = $this->metadataLoader->load();

        return TwigRenderer::create()
            ->render(
                file_get_contents(__DIR__ . '/templates/conditions.md.twig'),
                new ArrayMap([
                    'operators' => $operators,
                ]),
            );
    }
}
