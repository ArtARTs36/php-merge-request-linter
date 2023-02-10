<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\DecodingFailedException;

class TextDecodingException extends MergeRequestLinterException implements DecodingFailedException
{
    //
}
