<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Github\Env;

use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\Str\Str;

class RequestID
{
    private const SUFFIX = '/merge';

    public function __construct(
        public readonly int $value,
    ) {
        //
    }

    public static function createFromRef(string $ref): self
    {
        $refStr = Str::make($ref);

        $id = $refStr->deleteWhenEnds(self::SUFFIX);

        if (! $id->isDigit()) {
            throw new EnvironmentVariableNotFound(VarName::RefName->value);
        }

        return new self($id->toInteger());
    }
}
