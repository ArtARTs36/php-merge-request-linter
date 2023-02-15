<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\CI\RemoteCredentials;

final class EmptyCredentials implements RemoteCredentials
{
    public function getToken(): string
    {
        return '';
    }
}
