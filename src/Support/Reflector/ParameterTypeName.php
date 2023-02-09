<?php

namespace ArtARTs36\MergeRequestLinter\Support\Reflector;

enum ParameterTypeName: string
{
    case String = 'string';
    case Bool = 'bool';
    case Int = 'int';
    case Float = 'float';
    case Array = 'array';
    case Object = 'object';
}
