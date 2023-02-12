<?php

namespace ArtARTs36\MergeRequestLinter\Domain\CI;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class CurrentlyNotMergeRequestException extends MergeRequestLinterException implements GettingMergeRequestException
{
    //
}
