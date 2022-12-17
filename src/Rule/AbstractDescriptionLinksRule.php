<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Attribute\Generic;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

abstract class AbstractDescriptionLinksRule extends AbstractRule implements Rule
{
    use DefinitionToNotes;

    /**
     * @param Set<string> $domains
     */
    final public function __construct(protected Set $domains)
    {
        //
    }

    /**
     * @param iterable<string> $domains
     */
    public static function make(#[Generic(Generic::OF_STRING)] iterable $domains): static
    {
        return new static(Set::fromList($domains));
    }
}
