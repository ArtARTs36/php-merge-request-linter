<?php

namespace ArtARTs36\MergeRequestLinter\Common\Reflector;

enum TypeName: string
{
    case String = 'string';
    case Bool = 'bool';
    case Int = 'int';
    case Float = 'float';
    case Array = 'array';
    case Object = 'object';
}
