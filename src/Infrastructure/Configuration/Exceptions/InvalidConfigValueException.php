<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\TransformConfigValueException;

class InvalidConfigValueException extends \Exception implements TransformConfigValueException
{
    //
}
