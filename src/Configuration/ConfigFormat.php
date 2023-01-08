<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

enum ConfigFormat: string
{
    case PHP = 'php';
    case JSON = 'json';
    case YAML = 'yaml';
}
