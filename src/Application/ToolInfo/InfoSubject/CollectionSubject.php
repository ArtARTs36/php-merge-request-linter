<?php

namespace ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject;

use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;

final class CollectionSubject implements InfoSubject
{
    /**
     * @param Arrayee<int, string> $values
     */
    public function __construct(
        private readonly string $theme,
        private readonly Arrayee $values,
    ) {
        //
    }

    public function describe(): string
    {
        return sprintf('%s: [%s]', $this->theme, $this->values->implode(', '));
    }
}
