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

    public function findFirst(Str $text): ?string
    {
        foreach ($this->finders as $finder) {
            $type = $finder->findFirst($text);

            if ($type !== null) {
                return $type;
            }
        }

        return null;
    }

    public function findAll(Str $text): array
    {
        $typeList = [];

        foreach ($this->finders as $finder) {
            $subTypeList = $finder->findAll($text);

            if (count($subTypeList) > 0) {
                array_push($typeList, ...$subTypeList);
            }
        }

        return array_values(array_unique($typeList));
    }
}
