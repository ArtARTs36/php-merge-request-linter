<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

abstract class AbstractDescriptionLinksRule extends AbstractRule implements Rule
{
    use DefinitionToNotes;

    /**
     * @param Map<string, string> $domains
     */
    final public function __construct(protected Map $domains)
    {
        //
    }

    /**
     * @param iterable<string> $domains
     */
    public static function make(iterable $domains): static
    {
        return new static(Map::fromList($domains));
    }
}
