<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

enum ConfigFormat: string
{
    case JSON = 'json';
    case YAML = 'yaml';

    /**
     * @return Arrayee<int, string>
     */
    public static function list(): Arrayee
    {
        return new Arrayee(array_map(static fn (\UnitEnum $enum) => $enum->name, self::cases()));
    }
}
