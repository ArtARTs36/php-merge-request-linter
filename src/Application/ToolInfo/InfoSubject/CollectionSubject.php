<?php

namespace ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

final readonly class CollectionSubject implements InfoSubject
{
    /**
     * @param Arrayee<int, string> $values
     */
    public function __construct(
        private string $theme,
        private Arrayee $values,
    ) {
    }

    public function describe(): string
    {
        return sprintf('%s: [%s]', $this->theme, $this->values->implode(', '));
    }
}
