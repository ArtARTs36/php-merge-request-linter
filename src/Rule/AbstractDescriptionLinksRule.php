<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;
use ArtARTs36\MergeRequestLinter\Support\Map;

abstract class AbstractDescriptionLinksRule implements Rule
{
    use DefinitionToNotes;

    final public function __construct(protected Map $domains)
    {
        //
    }

    public static function make(array $domains): static
    {
        return new static(Map::fromList($domains));
    }
}
