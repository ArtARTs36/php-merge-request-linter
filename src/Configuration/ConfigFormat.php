<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

enum ConfigFormat: string
{
    case PHP = 'php';
    case JSON = 'json';
    case YAML = 'yaml';

    /**
     * @return Arrayee<string>
     */
    public static function list(): Arrayee
    {
        return new Arrayee(array_map(static fn (\UnitEnum $enum) => $enum->name, self::cases()));
    }
}
