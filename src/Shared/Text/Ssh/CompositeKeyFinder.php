<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Text\Ssh;

use ArtARTs36\Str\Str;

final class CompositeKeyFinder implements SshKeyFinder
{
    /***
     * @param iterable<SshKeyFinder> $finders
     */
    public function __construct(
        private readonly iterable $finders,
    ) {
    }

    public function find(Str $text, bool $stopOnFirst): array
    {
        $typeList = [];

        foreach ($this->finders as $finder) {
            $subTypeList = $finder->find($text, $stopOnFirst);

            if (count($subTypeList) > 0) {
                array_push($typeList, ...$subTypeList);
            }
        }

        return array_values(array_unique($typeList));
    }
}
